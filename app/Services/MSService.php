<?php

namespace App\Services;


use App\Models\Analysis;
use App\Models\Constant;
use App\Models\DB;
use App\Models\MS\Deferrals;
use App\Models\MS\DeferralTypes;
use App\Models\MS\Donations;
use App\Models\MS\DonationTestResults;
use App\Models\MS\DonationTypes;
use App\Models\MS\Examinations;
use App\Models\MS\IdentityDocs;
use App\Models\MS\Immunologies;
use App\Models\MS\MedicalTestResults;
use App\Models\MS\MedicalTypes;
use App\Models\MS\Organizations;
use App\Models\MS\PersonAddresses;
use App\Models\MS\PersonCards;
use App\Models\Org;
use App\Models\Osmotr;
use App\Models\Otvod;
use App\Models\Personas;
use App\Models\Scheduled;
use App\Models\Source;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class MSService
{
    public function send($ids = [])
    {
        //создаю подключение к МС
        $this->db = DB::where('active', true)->first();
        Config::set("database.connections.sqlsrv", [
            'driver' => 'sqlsrv',
            'host' => $this->db->host,
            'port' => $this->db->port,
            'database' => $this->db->database,
            'username' => $this->db->username,
            'password' => $this->db->password,
            'charset' => env('DB_CHARSET_MS', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            // 'encrypt' => env('DB_ENCRYPT_MS', 'yes'),
            'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE_MS', 'true'),
        ]);

        $this->orgs = Org::all()->pluck('start', 'code');
        $this->medicaltypes = MedicalTypes::all()->pluck('Id', 'Code');
        $this->deferraltypes = DeferralTypes::all()->pluck('UniqueId', 'Code');
        $this->now = Carbon::now()->format("Y_m_d-H_i_s");

        $status = Scheduled::where('run', true)->first();
        if (!is_null($status)) {
            return false;
        }
        $command = Scheduled::where('title', 'ms')->first();
        $command['run'] = true;
        $command->save();
        try {
            //перенос всех записей в мс
            $this->MSSend(Source::class, $ids);
            $this->MSSend(Otvod::class, $ids);
            $this->MSSend(Analysis::class, $ids);
            $this->MSSend(Osmotr::class, $ids);

            Personas::truncate();
        } finally {
            $command['run'] = false;
            $command->save();
        }
        return true;
    }

    private function MSSend($model, $ids = [])
    {
        $handle_success = LogService::createFile('eibd', $this->now . '_' . $model::LOG_NAME . '_success', $model::LOG_FIELD_MS);
        $handle_bad = LogService::createFile('eibd', $this->now . '_' . $model::LOG_NAME . '_bad', $model::LOG_FIELD_MS);
        $query = $model::query();
        if (!empty($ids)) {
            $query = $query->whereIn("card_id", $ids);
        }
        $data = $query->get();
        foreach ($data as $item) {
            try {
                if ($item->validated) {
                    $item['stop'] = false;
                    $item['message'] = 'Успешно';
                    $method = class_basename($model);
                    $this->{$method}($item);
                    LogService::addLine($handle_success, $model::LOG_FIELD_MS, $item);
                } else {
                    $item['message'] = 'Ошибка валидации';
                    LogService::addLine($handle_bad, $model::LOG_FIELD_MS, $item);

                }
            } catch (\Exception $exception) {
                $message = $exception->getMessage();

                if (empty($message) && property_exists($exception, 'errorInfo')) {
                    $message = implode(' | ', $exception->errorInfo);
                }

                $item['message'] = $message ?: 'Неизвестная ошибка: ' . get_class($exception);
                LogService::addLine($handle_bad, $model::LOG_FIELD_MS, $item);

            }
        }
        $model::truncate();
    }

    private function createBody($item, $fields = [])
    {
        $body = [];
        foreach ($fields as $field) {
            if (isset($field['default']))
                $body[$field['ms']] = config($field['default']);
            if (isset($field['db_const']))
                $body[$field['ms']] = $this->db->{$field['db_const']};
            if (!isset($field['default']) && !isset($field['db_const']))
                if (isset($item[$field['aist']]))
                    $body[$field['ms']] = $item[$field['aist']];
        }
        return $body;
    }

    private function Source($item)
    {
        //создания уникального ключа и проверка компании
        $item = $this->createID($item);
        if (!$item['stop']) {
            //работа с адресами
            $item = $this->createAddress($item);
            //работа с документами
            $item = $this->createDocs($item);
            //работа с персональной картой
            $item = $this->createPersonCards($item);
            //работа с донацией
            $item = $this->createDonation($item);
            //работа с анализами
            $item = $this->createDonationTestResults($item, Source::TYPES);
            //работа с имунологие
            $item = $this->createImmunologies($item);
        }
        return $item;
    }

    private function Otvod($item)
    {
        //создания уникального ключа и проверка компании
        $item = $this->createID($item, 'otvod_kod_128');
        if (!$item['stop']) {
            //работа с адресами
            $item = $this->createAddress($item);
            //работа с документами
            $item = $this->createDocs($item);
            //работа с персональной картой
            $item = $this->createPersonCards($item);
            //работа с отводом
            $item = $this->createDeferrals($item);//otvod_128
        }
        return $item;
    }

    private function Analysis($item)
    {
        //создания уникального ключа и проверка компании
        $item = $this->createID($item, 'anal_org_kod_128');
        if (!$item['stop']) {
            //работа с адресами
            $item = $this->createAddress($item);
            //работа с документами
            $item = $this->createDocs($item);
            //работа с персональной картой
            $item = $this->createPersonCards($item);
            //работа с экзаменами
            $item['ExamType'] = 2;
            $item = $this->createExaminations($item);//
            //работа с анализами
            $item = $this->createMedicalTestResults($item, Analysis::TYPES);
        }
        return $item;
    }

    private function Osmotr($item)
    {
        //создания уникального ключа и проверка компании
        $item = $this->createID($item, 'osmtor_org_kod_128');
        if (!$item['stop']) {
            //работа с адресами
            $item = $this->createAddress($item);
            //работа с документами
            $item = $this->createDocs($item);
            //работа с персональной картой
            $item = $this->createPersonCards($item);
            //работа с экзаменами
            $item['ExamType'] = 1;
            $item['analysis_date'] = $item['date'];
            $item = $this->createExaminations($item);//
            //работа с анализами
            $item = $this->createMedicalTestResults($item, Osmotr::TYPES);
        }
        return $item;
    }

    private function createID($item, $two_kod = 'donation_org_128')
    {
        $block = Org::where('code', $item[$two_kod])->where('block', true)->first();
        if ($block) {
            $item['stop'] = true;
            $item['message'] = "Попытка создать на заблокированную компанию";
            return $item;
        }

        if (isset($this->orgs[$item['kod_128']])) {
            $item['org_min'] = $this->orgs[$item['kod_128']];
        } elseif (isset($this->orgs[$item[$two_kod]])) {
            // Если основного нет пробуем запасной
            $item['OrgId'] = $item['OrgIdTwo'];
            $item['org_min'] = $this->orgs[$item[$two_kod]];
        } else {
            // Если вообще не найдено
            $item['stop'] = true;
            $item['message'] = "Компания не найдена";
            $item['org_min'] = 0;
        }

        $item['card_id'] = $item['org_min'] + $item['card_id'];
        return $item;
    }

    private function createAddress($item)
    {
        if (isset($item['address']))
            $item['PersonAddresses'] = PersonAddresses::firstOrCreate($this->createBody($item, PersonAddresses::Fields))['UniqueId'];
        return $item;
    }

    private function createDocs($item)
    {
        $item['IdentityDocs'] = IdentityDocs::firstOrCreate($this->createBody($item, IdentityDocs::Fields))['UniqueId'];
        return $item;
    }

    private function createPersonCards($item)
    {
        PersonCards::updateOrCreate(
            ['UniqueId' => $item['card_id']],
            $this->createBody($item, PersonCards::Fields));
        return $item;
    }

    private function createDonation($item)
    {
        if (isset($item['donation_id'])) {
            $donation = Donations::where('Barcode', $item['donation_barcode'])->first();
            if (is_null($donation)) {
                $item = $this->UniqueIdCreate(Donations::class, $item);
            } else {
                $item[Donations::ID] = $donation['UniqueId'];
                $donation->update($this->createBody($item, Donations::Fields));
            }
        }
        return $item;
    }

    private function createDonationTestResults($item)
    {
        $types = Source::TYPES;
        foreach ($types as $ms => $mysql) {
            if ($item[$mysql] != 0) {
                $item['test_value'] = $item[$mysql];
                $item['test_type_id'] = $this->medicaltypes[$ms];
                DonationTestResults::updateOrCreate(
                    [
                        'DonationId' => $item['donation_id'],
                        'TestTypeId' => $item['test_type_id'],
                    ],
                    $this->createBody($item, DonationTestResults::Fields)
                );
            }
        }
        return $item;
    }

    private function createImmunologies($item)
    {
        Immunologies::firstOrCreate($this->createBody($item, Immunologies::Fields));
        return $item;
    }


    private function createExaminations($item)
    {
        $def = Deferrals::where('DonorId', $item['card_id'])->where('StartDate', $item['analysis_date'])
            ->first();
        $item['def_id'] = $def ? $def['UniqueId'] : null;
        //        беру послежний отвод для персональной карты
//    если его нету то создаю запись
//    если есть и дата создания отвода (analysis_date) равна дате StartDate
//    мы обновляем запись
//    а если не сходится создаю новую
        $examination = Examinations::where('ExamType', $item['ExamType'])->where('DonorId', $item['card_id'])->where('ExamDate', $item['analysis_date'])
            ->first();

        if (is_null($examination)) {
            // если записи нет → создаем новую
            $item = $this->UniqueIdCreate(Examinations::class, $item);
            $item['analize_update'] = false;
        } else {
            // если дата совпадает → обновляем существующую
            $item[Examinations::ID] = $examination['UniqueId'];
            $examination->update($this->createBody($item, Examinations::Fields));
            $item['analize_update'] = true;
        }
        return $item;
    }

    private function createMedicalTestResults($item, $types)
    {
        foreach ($types as $ms => $mysql) {
//            $item['test_valid'] = true;//написать проверку что значение подходит
            if ($item[$mysql] != 0) {
                $item['test_value'] = $item[$mysql];
                $item['test_type_id'] = $this->medicaltypes[strtoupper($ms)];
                if ($item['analize_update']) {
                    MedicalTestResults::updateOrCreate(
                        [
                            'ExaminationId' => $item['examination_id'],
                            'TestTypeId' => $item['test_type_id'],
                        ],
                        $this->createBody($item, MedicalTestResults::Fields));
                } else {
                    // создаем всегда новые тесты
                    MedicalTestResults::firstOrCreate($this->createBody($item, MedicalTestResults::Fields));
                }
            }
        }
        return $item;
    }

    private function createDeferrals($item)
    {
        //        беру отвод по дате и карте
//    если его нету то создаю запись
//    если есть
//    мы обновляем запись
        $item['created_date'] = date('Y-m-d', strtotime($item['created']));
        $deferrals = Deferrals::where('DonorId', $item['card_id'])
            ->where('StartDate', $item['created_date'])
            ->first();
        if (is_null($deferrals)) {
            // если записи нет → создаем новую и присваиваем id
            $item = $this->UniqueIdCreate(Deferrals::class, $item);
        } else {
            $item[Deferrals::ID] = $deferrals['UniqueId'];
            // если дата совпадает → обновляем существующую
            $deferrals->update($this->createBody($item, Deferrals::Fields));
        }
        return $item;
    }

    private function UniqueIdCreate($model, $item)//проверить
    {
        $model_id = $model::orderByDesc('UniqueId')->limit(1)->first();
        if (is_null($model_id) || $model_id['UniqueId'] < $item['org_min'])
            $item[$model::ID] = $item['org_min'];
        else {
            $item[$model::ID] = $model_id['UniqueId'] + 1;
        }
        $model::firstOrCreate($this->createBody($item, $model::Fields));
        return $item;
    }
}

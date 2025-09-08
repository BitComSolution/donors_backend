<?php

namespace App\Services;


use App\Models\Analysis;
use App\Models\Constant;
use App\Models\DB;
use App\Models\MS\Deferrals;
use App\Models\MS\DeferralTypes;
use App\Models\MS\Donations;
use App\Models\MS\DonationTypes;
use App\Models\MS\Examinations;
use App\Models\MS\IdentityDocs;
use App\Models\MS\MedicalTestResults;
use App\Models\MS\MedicalTypes;
use App\Models\MS\Organizations;
use App\Models\MS\PersonAddresses;
use App\Models\MS\PersonCards;
use App\Models\Org;
use App\Models\Osmotr;
use App\Models\Otvod;
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
        $db = DB::where('active', true)->first();
        Config::set("database.connections.sqlsrv", [
            'driver' => 'sqlsrv',
            'host' => $db->host,
            'port' => $db->port,
            'database' => $db->database,
            'username' => $db->username,
            'password' => $db->password,
            'charset' => env('DB_CHARSET_MS', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            // 'encrypt' => env('DB_ENCRYPT_MS', 'yes'),
            'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE_MS', 'true'),
        ]);

        $this->orgs = Org::all()->pluck('start', 'code');
        $this->medicaltypes = MedicalTypes::all()->pluck('Id', 'Code');

        $status = Scheduled::where('run', true)->first();
        if (!is_null($status)) {
            return false;
        }
        $command = Scheduled::where('title', 'ms')->first();
        $command['run'] = true;
        $command->save();


        //перенос всех записей в мс
        $source = Source::where("validated", true);
        if (!empty($ids)) {
            $source = $source->whereIn("card_id", $ids);
        }
        $source = $source->get();
        foreach ($source as $item) {
            try {
                $this->createRecord($item);
            } catch (\Exception $exception) {
                Log::channel('ms')->info('Error ' . $item['card_id'] . '  ' . $exception->getMessage());
//                dump($exception->getMessage());
            }
        }
        $source = Source::all();
        $source->each->delete();


//        //перенос отводов
        $otvod = Otvod::where("validated", true);
        if (!empty($ids)) {
            $otvod = $otvod->whereIn("card_id", $ids);
        }
        $otvod = $otvod->get();
        $this->deferraltypes = DeferralTypes::all()->pluck('UniqueId', 'Code');
        foreach ($otvod as $item) {
            try {
                $this->createRecordOtvod($item);
            } catch (\Exception $exception) {
                Log::channel('ms')->info('Error otvod' . $item['card_id'] . '  ' . $exception->getMessage());
//                dump($exception->getMessage());
            }
        }
        $otvod = Otvod::all();
        $otvod->each->delete();


        //перенос анализов
        $analysis = Analysis::where("validated", true);
        if (!empty($ids)) {
            $analysis = $analysis->whereIn("card_id", $ids);
        }
        $analysis = $analysis->get();
        foreach ($analysis as $item) {
            try {
                $this->createRecordAnalysis($item);
            } catch (\Exception $exception) {
                Log::channel('ms')->info('Error analysis' . '  ' . $exception->getMessage());
//                dump($exception->getMessage());
            }
        }
        $analysis = Analysis::all();
        $analysis->each->delete();


        //перенос осмотров
        $osmotr = Osmotr::where("validated", true);
        if (!empty($ids)) {
            $osmotr = $osmotr->whereIn("card_id", $ids);
        }
        $osmotr = $osmotr->get();
        foreach ($osmotr as $item) {
            try {
                $this->createRecordOsmotr($item);
            } catch (\Exception $exception) {
                Log::channel('ms')->info('Error osmotr' . '  ' . $exception->getMessage());
//                dump($exception->getMessage());
            }
        }
        $osmotr = Osmotr::all();
        $osmotr->each->delete();

        //освобождение очереди
        $command['run'] = false;
        $command->save();
        return true;

    }

    private function createBody($item, $fields = [])
    {
        $body = [];
        foreach ($fields as $field) {
            $body[$field['ms']] = (!isset($field['default'])) ? $item[$field['aist']] : config($field['default']);
            $body[$field['ms']] = (!isset($field['db_const'])) ? $item[$field['aist']] : Constant::where('name', $field['db_const'])->first()->name;
        }
        return $body;
    }

    private function createRecord($item)
    {
        //работа с адресами
        $item = $this->createAddress($item);
        //работа с документами
        $item = $this->createDocs($item);
        //работа с персональной картой
        $item = $this->createPersonCards($item);
        //работа с донацией
        $item = $this->createDonation($item);
//        //работа с экзаменами
//        $item['ExamType'] = 1;
//        $item['analysis_date'] = $item['research_date'];
//        $item = $this->createExaminations($item);
//        //работа с анализами
//        $item = $this->createMedicalTestResults($item, Source::TYPES);
        return $item;
    }

    private function createRecordOtvod($item)
    {
        //работа с адресами
        $item = $this->createAddress($item);
        //работа с документами
        $item = $this->createDocs($item);
        //работа с персональной картой
        $item = $this->createPersonCards($item);
        //работа с отводом
        $item = $this->createDeferrals($item);

        return $item;
    }

    private function createRecordAnalysis($item)
    {
        //работа с адресами
        $item = $this->createAddress($item);
        //работа с документами
        $item = $this->createDocs($item);
        //работа с персональной картой
        $item = $this->createPersonCards($item);
        //работа с экзаменами
        $item['ExamType'] = 2;
        $item = $this->createExaminations($item);
        //работа с анализами
        $item = $this->createMedicalTestResults($item, Analysis::TYPES);
        return $item;
    }

    private function createRecordOsmotr($item)
    {
        //работа с адресами
        $item = $this->createAddress($item);
        //работа с документами
        $item = $this->createDocs($item);
        //работа с персональной картой
        $item = $this->createPersonCards($item);
        //работа с экзаменами
        $item['ExamType'] = 1;
        $item['analysis_date'] = $item['date'];
        $item = $this->createExaminations($item);
        //работа с анализами
        $item = $this->createMedicalTestResults($item, Osmotr::TYPES);
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
        $item['card_id'] = $this->orgs[$item['kod_128']] + $item['card_id'];
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
            }
        }
        return $item;
    }

    private function createExaminations($item)
    {
        //        беру послежний отвод для персональной карты
//    если его нету то создаю запись
//    если есть и дата создания отвода (analysis_date) равна дате StartDate
//    мы обновляем запись
//    а если не сходится создаю новую
        $examination = Examinations::where('DonorId', $item['card_id'])->where('ExamDate', $item['analysis_date'])
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
                    // обновляем если тест уже есть
                    $analize = MedicalTestResults::where('ExaminationId', $item['examination_id'])
                        ->where('TestTypeId', $item['test_type_id'])
                        ->first();

                    if ($analize) {
                        $analize->update($this->createBody($item, MedicalTestResults::Fields));
                    } else {
                        $item = $this->UniqueIdCreate(MedicalTestResults::class, $item);
                    }
                } else {
                    // создаем всегда новые тесты
                    $item = $this->UniqueIdCreate(MedicalTestResults::class, $item);
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
        $min = Constant::where('name', 'UniqueIdMIN')->first()->value;
        if (is_null($model_id) || $model_id['UniqueId'] < $min)
            $item[$model::ID] = $min;
        else {
            $item[$model::ID] = $model_id['UniqueId'] + 1;
        }
        $model::firstOrCreate($this->createBody($item, $model::Fields));
        return $item;
    }
}

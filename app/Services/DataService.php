<?php

namespace App\Services;


use App\Models\Analysis;
use App\Models\DB;
use App\Models\DefTypes;
use App\Models\MS\DeferralTypes;
use App\Models\MS\DonationTypes;
use App\Models\MS\Organizations;
use App\Models\Osmotr;
use App\Models\Otvod;
use App\Models\Source;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class DataService
{
    protected $convert_item = [];//объект что изменяем для отправки в мс
    protected $date_fields = [];//поля даты что приобразуем в формат для мс
    protected $organizations;//список организаций

    protected $donation_types;//список донаций
    protected $donation_types_const;//список донаций константы
    protected $vng;//вид на жительство
    protected $deferral_types;//список типов отводов из МС
    protected $def_types_const;//список типов отводов из файла

    public function __construct()
    {
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
        $this->donation_types = DonationTypes::all()->pluck('UniqueId', 'Code');
        $this->organizations = Organizations::all()->pluck('UniqueId', 'OrgCode');
        $this->deferral_types = DeferralTypes::all()->pluck('UniqueId', 'Code');
        $this->def_types_const = DefTypes::all()->pluck('eidbCode', 'aistCode');
        $this->donation_types_const = config('const.DonationType');
        $this->vng = config('const.DocType.VNG');
    }

    public function SourceConvert($item)
    {
        $model = Source::class;
        $this->convert_item = $item;
        $this->date_fields = $model::DATE_FIELDS;
        $this->transformData($model);
        $this->gender();
        $this->address();
        $this->dates();
        $this->LastModifiedDate();
        $this->rh_factor();
        $this->kell();
        $this->OrgId();
        $this->donation_org_128();
        $this->document_type();
        $this->phenotype();//тут надо придумать как лучше
        $this->donation_type_id();
        $this->analis();
//       dd( array_diff($item, $this->convert_item));//показывает какие строчки поменялись
//        dump($item);//исходный
//        dd($this->convert_item);//готовый
        return $this->convert_item;
    }

    public function OtvodConvert($item)
    {
        $model = Otvod::class;
        $item['created'] = $item['ex_created'];
        unset($item['ex_created']);
        $this->convert_item = $item;
        $this->date_fields = $model::DATE_FIELDS;
        $this->transformData($model);
        $this->gender();
        $this->address();
        $this->dates();
        $this->LastModifiedDate();
        $this->rh_factor();
        $this->kell();
        $this->OrgId();
        $this->donation_org_128();
        $this->document_type();
        $this->phenotype();
        $this->typeDefferals();
//        dump($item);
//        dd($this->convert_item);
        return $this->convert_item;
    }

    public function AnalysisConvert($item)
    {
        $model = Analysis::class;
        $item['card_id'] = $item['num'];
        $item['rh_factor'] = $item['rh'];
        $item['created'] = Carbon::now()->addHours(3)->format('Y-m-d H:i:s');
        unset($item['rh']);
        $this->convert_item = $item;
        $this->date_fields = $model::DATE_FIELDS;
        $this->OrgId();
        $this->transformData($model);
        $this->gender();
        $this->address();
        $this->dates();
        $this->LastModifiedDate();
        $this->rh_factor();
        $this->kell();
        $this->phenotype();
//       dd( array_diff($item, $this->convert_item));//показывает какие строчки поменялись
//        dump($item);//исходный
//        dd($this->convert_item);//готовый
        return $this->convert_item;
    }

    public function OsmotrConvert($item)
    {
        $model = Osmotr::class;
        $item['created'] = Carbon::now()->addHours(3)->format('Y-m-d H:i:s');
        $this->convert_item = $item;
        $this->date_fields = $model::DATE_FIELDS;
        $this->OrgId();
        $this->transformData($model);
        $this->gender();
        $this->address();
        $this->dates();
        $this->LastModifiedDate();
        $this->rh_factor();
        $this->kell();
        $this->phenotype();
//       dd( array_diff($item, $this->convert_item));//показывает какие строчки поменялись
//        dump($item);//исходный
//        dd($this->convert_item);//готовый
        return $this->convert_item;
    }

    private function transformData($model)//убираем лишние символы
    {
        foreach ($model::TRANS_FIELDS as $field) {
            if (isset($this->convert_item[$field]))
                $this->convert_item[$field] = str_replace($model::SYMBOLS, "", $this->convert_item[$field]);
        }
        unset($this->convert_item['Id']);
    }

    private function gender()
    {
        if (!((empty($this->convert_item['gender'])) || (is_null($this->convert_item['gender'])))) {
            switch (strtoupper($this->convert_item['gender'])) {
                case "М":
                {
                    $this->convert_item['gender'] = 1;
                    break;
                }
                case "Ж":
                {
                    $this->convert_item['gender'] = 2;
                    break;
                }
                default:
                    $this->convert_item['gender'] = null;
            }
        } elseif (!is_null($this->convert_item['middlename'])) {
            $this->convert_item['gender'] = (preg_match('(.*ич\z)', strtolower($this->convert_item['middlename']))) ? 1 : 2;
        }
    }

    private function address()
    {
        $this->convert_item['address'] = str_replace('Прочие регионы, ', "", $this->convert_item['address']);
    }

    private function dates()
    {
        foreach ($this->date_fields as $date) {
            if (isset($this->convert_item[$date]))
                $this->convert_item[$date] = Carbon::parse($this->convert_item[$date])->format('Y-m-d H:i:s');
        }
    }

    private function LastModifiedDate()
    {
        $this->convert_item['LastModifiedDate'] = Carbon::now()->addHours(3)->format('Y-m-d H:i:s');
    }

    private function rh_factor()
    {
        switch ($this->convert_item['rh_factor']) {
            case "+":
            {
                $this->convert_item['rh_factor'] = 1;
                break;
            }
            case "-":
            {
                $this->convert_item['rh_factor'] = -1;
                break;
            }
            default:
                $this->convert_item['rh_factor'] = null;
        }

    }

    private function kell()

    {
        switch ($this->convert_item['kell']) {
            case "K":
            case "+":
            {
                $this->convert_item['kell'] = 1;
                break;
            }
            case "-":
            {
                $this->convert_item['kell'] = -1;
                break;
            }
            default:
                $this->convert_item['kell'] = null;
        }
    }

    private function OrgId()
    {
        try {
            if ($this->convert_item['kod_128'] != 0) {
                if (isset($this->organizations[$this->convert_item['kod_128']]))
                    $this->convert_item['OrgId'] = $this->organizations[$this->convert_item['kod_128']];
            }
        } catch (\Exception $exception) {
            $this->convert_item['OrgId'] = 'error';
        }
    }

    private function donation_org_128()
    {
        try {
            if (isset($this->convert_item['donation_org_128']))
                $this->convert_item['donation_org_128'] = $this->organizations[$this->convert_item['donation_org_128']];
        } catch (\Exception $exception) {
            $this->convert_item['donation_org_128'] = 'error';
        }
    }

    private function document_type()
    {
        try {
            $this->convert_item['document_number'] = $this->addZero($this->convert_item['document_number']);
            if (isset($this->convert_item['document_type']) && $this->convert_item['document_type'] == $this->vng) {
                $document = $this->convert_item['document_serial'] . $this->convert_item['document_number'];
                $this->convert_item['document_serial'] = mb_substr($document, 0, 2);
                $this->convert_item['document_number'] = mb_substr($document, 2, 100);
            }
        } catch (\Exception $exception) {
            $this->convert_item['document_serial'] = 'error';
            $this->convert_item['document_number'] = 'error';
            $this->convert_item['document_type'] = 'error';
        }
    }

    private function phenotype()
    {
        try {
            $phenotype = '';
            if (preg_match('/[A-Za-z]/', $this->convert_item['phenotype'])) {

                $phenotype_array = str_replace('dd', "d", $this->convert_item['phenotype']);
                $pos = stripos($phenotype_array, '_w');
                $three = ($pos !== false) ? 2 : 1;
                $phenotype_array = str_replace('_w', "", $phenotype_array);
                $phenotype_array = str_split($phenotype_array);
                $ph = ['C', 'c', 'D', 'E', 'e'];
                foreach ($ph as $key => $value) {
                    if ($key == 2)
                        $phenotype .= $three;
                    $phenotype .= ($phenotype_array[$key] == $value) ? 2 : 1;

                }
            } else {
                foreach (str_split($this->convert_item['phenotype']) as $phen) {
                    switch ($phen) {
                        case "+":
                        {
                            $phenotype .= 2;
                            break;
                        }
                        case "-":
                        {
                            $phenotype .= 1;
                            break;
                        }
                        case "%":
                        {
                            $phenotype .= 3;
                            break;
                        }
                        default:
                        {
                            $phenotype .= 0;
                        }
                    }
                }
            }
            $this->convert_item['phenotype'] = intval($phenotype);
        } catch (\Exception $exception) {
            dump($this->convert_item['phenotype']);
        }
    }

    private function donation_type_id()
    {
        try {
            if (isset($this->donation_types_const[$this->convert_item['donation_type_id']])) {
                $this->convert_item['donation_type_id'] = $this->donation_types_const[$this->convert_item['donation_type_id']];
            }
            $this->convert_item['donation_type_id'] = $this->donation_types[$this->convert_item['donation_type_id']];
        } catch (\Exception $exception) {
            $this->convert_item['donation_type_id'] = 'error';
        }
    }

    private function addZero($string)
    {
        while (strlen($string) < 6) {
            $string = '0' . $string;
        }
        return $string;
    }

    private function typeDefferals()
    {
        try {
            if (isset($this->deferral_types[$this->convert_item['ex_type']])) {
                $this->convert_item['ex_type'] = $this->deferral_types[$this->convert_item['ex_type']];
            } else {
                $name = $this->def_types_const[$this->convert_item['ex_type']];
                $this->convert_item['ex_type'] = $this->deferral_types[$name];
            }
        } catch (\Exception $exception) {
            $this->convert_item['ex_type'] = 'not_found';
        }

    }

    private function analis()
    {
        $map = [
            'ДА' => 'POS',
            'НЕТ' => 'NEG',
        ];

        $fields = ['vich', 'hbs', 'sif', 'hcv'];

        foreach ($fields as $field) {
            if (isset($map[$this->convert_item[$field]])) {
                $this->convert_item[$field] = $map[$this->convert_item[$field]];
            }
        }
    }
}

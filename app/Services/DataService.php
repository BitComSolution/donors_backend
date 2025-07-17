<?php

namespace App\Services;


use App\Models\Analysis;
use App\Models\MS\DonationTypes;
use App\Models\MS\Organizations;
use App\Models\Otvod;
use App\Models\Source;
use Carbon\Carbon;

class DataService
{
    protected $convert_item = [];//объект что изменяем для отправки в мс
    protected $date_fields = [];//поля даты что приобразуем в формат для мс
    protected $organizations;//список организаций

    protected $donation_types;//список донаций
    protected $donation_types_const;//список донаций константы
    protected $vng;//вид на жительство

    public function __construct()
    {
        $this->donation_types = DonationTypes::all()->pluck('UniqueId', 'Code');
        $this->organizations = Organizations::all()->pluck('UniqueId', 'OrgCode');
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
//        dump($item);
//        dd($this->convert_item);
        return $this->convert_item;
    }

    public function AnalysisConvert($item)
    {
        $model = Analysis::class;
        $item['rh_factor'] = $item['rh'];
        $item['created'] = Carbon::now()->addHours(3)->format('Y-d-m H:i:s');
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
                $this->convert_item[$date] = Carbon::parse($this->convert_item[$date])->format('Y-d-m H:i:s');
        }
    }

    private function LastModifiedDate()
    {
        $this->convert_item['LastModifiedDate'] = Carbon::now()->addHours(3)->format('Y-d-m H:i:s');
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
        if ($this->convert_item['kod_128'] != 0) {
            if (isset($this->organizations[$this->convert_item['kod_128']]))
                $this->convert_item['OrgId'] = $this->organizations[$this->convert_item['kod_128']];
        }

    }

    private function donation_org_128()
    {
        if (isset($this->convert_item['donation_org_128']))
            $this->convert_item['donation_org_128'] = $this->organizations[$this->convert_item['donation_org_128']];
    }

    private function document_type()
    {
        $this->convert_item['document_number'] = $this->addZero($this->convert_item['document_number']);
        if (isset($this->convert_item['document_type']) && $this->convert_item['document_type'] == $this->vng) {
            $document = $this->convert_item['document_serial'] . $this->convert_item['document_number'];
            $this->convert_item['document_serial'] = mb_substr($document, 0, 2);
            $this->convert_item['document_number'] = mb_substr($document, 2, 100);
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
        if (isset($this->donation_types_const[$this->convert_item['donation_type_id']])) {
            $this->convert_item['donation_type_id'] = $this->donation_types_const[$this->convert_item['donation_type_id']];
        }
        $this->convert_item['donation_type_id'] = $this->donation_types[$this->convert_item['donation_type_id']];
    }

    private function addZero($string)
    {
        while (strlen($string) < 6) {
            $string = '0' . $string;
        }
        return $string;
    }
}

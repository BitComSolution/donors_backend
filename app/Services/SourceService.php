<?php

namespace App\Services;

use App\Models\Donors;
use App\Models\EventLog;
use App\Models\Logs;
use App\Models\Source;
use App\Models\TWO\BloodData;
use App\Models\TWO\Otvod as OtvodMS;
use App\Models\Otvod;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SourceService
{
    public function dbSynchronize()
    {
        $source = Source::all();
        $source->each->delete();
        $otvod = Otvod::all();
        $otvod->each->delete();
        EventLog::create(['type' => 'ready']);
        $saved = Donors::all();
        $mysql = BloodData::whereNotIn('card_id', $saved->pluck('id_mysql'))->get()->values();
        $all = [];
        $error = [];
        foreach ($mysql as $donor) {
            $data = $this->transformData(Source::class, $donor);
            try {
                $rule = Source::RULE;
                $rule = array_merge($rule, $this->GetRuleDoc($data));
                $this->phenotype($data);
                $validator = Validator::make($data, $rule);
//                if($validator->fails())
//                    dump($data['card_id']);
//                    dd($validator->failed());
                $data['validated'] = !$validator->fails();
                Source::create($data);
                $all[] = $data;
            } catch (\Exception $exception) {
                $error[] = $data;
                continue;
            }
        }
        if (!empty($all))
            $this->createLog('all', $all);
        if (!empty($error))
            $this->createLog('bad', $error);


        $all = [];
        $error = [];
        $otvodMS = OtvodMS::all();
        foreach ($otvodMS as $ms) {
            $data = $this->transformData(Otvod::class, $ms);
            try {
                $data['created'] = $data['ex_created'];
                unset($data['ex_created']);
                $rule = Otvod::RULE;
                $rule = array_merge($rule, $this->GetRuleDoc($data));
                $this->phenotype($data);
                $validator = Validator::make($data, $rule);
                $data['validated'] = !$validator->fails();
                Otvod::create($data);
                $all[] = $data;
            } catch (\Exception $exception) {
                $error[] = $data;
                continue;
            }
        }
//        if (!empty($all))
//            $this->createLog('otvod_all', $all);
//        if (!empty($error))
//            $this->createLog('otvod_bad', $error);
        return [];
    }

    public function sendCommand($start, $end)
    {
        $client = Http::post(config('aist.url') . '/start', [
            "startDate" => $start,
            "endDate" => $end
        ]);
        //отправить команду чтобы сервис обновился
        return [];
    }

    public function createLog($name, $list)
    {
        $fields = Logs::FIELD;
        $csvFileName = $name . '_conv_' . Carbon::now()->format("Y_m_d-H_i_s") . '.csv';
        $handle = fopen('php://temp/maxmemory:' . (5 * 1024 * 1024), 'r+');
        fputcsv($handle, $fields);
        foreach ($list as $donor) {
            $line = [];
            foreach ($fields as $field) {
                $line[] = $donor[$field];
            }
            fputcsv($handle, $line);
        }
        rewind($handle);
        $output = stream_get_contents($handle);
        Storage::disk('local')->put($csvFileName, $output);
        fclose($handle);
        Logs::create(['name' => $name, 'error' => ($name == 'bad') ? true : false, 'file' => $csvFileName]);
    }

    public function failLog()
    {
        EventLog::create(['type' => 'fail']);
    }

    private function transformData($model, $data)
    {
        $data = $data->getOriginal();
        foreach ($model::TRANS_FIELDS as $field) {
            if (isset($data[$field]))
                $data[$field] = str_replace($model::SYMBOLS, "", $data[$field]);
        }
        unset($data['Id']);
        return $data;
    }

    private function GetRuleDoc(&$item)
    {
        $item['document_number'] = $this->addZero($item['document_number']);
        if (strlen($item['document_serial']) == 3) {
            $item['document_type'] = config('const.DocType.VNG');
            $rules = ['document_serial' => ['required', 'regex:/^(\d{3})$/u'],
                'document_number' => ['required', 'regex:/^(\d{1,7})$/u']];

        } elseif (preg_match('/[A-Za-z]/', $item['document_serial'])) {
            $item['document_type'] = config('const.DocType.INPassport');
            $rules = ['document_serial' => ['required', 'regex:/^([\da-zA-Z]{1,5})$/u'],
                'document_number' => ['required', 'regex:/^(\d{1,7})$/u']];

        } else {
            $item['document_type'] = config('const.DocType.Passport');
            $rules = ['document_serial' => ['required', 'regex:/^(\d{4})$/u'],
                'document_number' => ['required', 'regex:/^(\d{6})$/u']];
        }

        return $rules;
    }

    private function addZero($string)
    {
        while (strlen($string) < 6) {
            $string = '0' . $string;
        }
        return $string;
    }

    private function phenotype(&$item)
    {
        $phenotype = '';
        if (preg_match('/[A-Za-z]/', $item['phenotype'])) {

            $phenotype_array = str_replace('dd', "d", $item['phenotype']);
//            $pos = stripos($phenotype_array, '_w');
//            $three = ($pos !== false) ? 2 : 1;
            $phenotype_array = str_replace('_w', "", $phenotype_array);
            $phenotype_array = str_split($phenotype_array);
            $ph = ['C', 'c', 'D', 'E', 'e'];
            foreach ($ph as $key => $value) {
//                if ($key == 2)
//                    $phenotype .= $three;
                $phenotype .= ($phenotype_array[$key] == $value) ? 2 : 1;

            }
        } else {
            foreach (str_split($item['phenotype']) as $phen) {
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
                    case "%": {
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
        $item['phenotype'] = intval($phenotype);
    }
}

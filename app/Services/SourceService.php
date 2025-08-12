<?php

namespace App\Services;

use App\Models\Analysis;
use App\Models\Donors;
use App\Models\EventLog;
use App\Models\Logs;
use App\Models\Scheduled;
use App\Models\Source;
use App\Models\TWO\AnalcliData;
use App\Models\TWO\BloodData;
use App\Models\TWO\Otvod as OtvodAist;
use App\Models\Otvod;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SourceService
{
    protected $service;

    public function dbSynchronize()
    {
        $status=Scheduled::where('run',true)->first();
        if(!is_null($status))
        {
            return false;
        }
        $command=Scheduled::where('title','aist')->first();
        $command['run']=true;
        $command->save();
        $this->service = new DataService;
        //очиска бд
        $source = Source::all();
        $source->each->delete();
        $otvod = Otvod::all();
        $otvod->each->delete();
        $analysis = Analysis::all();
        $analysis->each->delete();
        EventLog::create(['type' => 'ready']);
        //получение новых записей
        $saved = Donors::all();
        $items = BloodData::whereNotIn('card_id', $saved->pluck('id_mysql'))->get()->values();
        $this->sync($items, Source::class);
        $items = OtvodAist::all();
        $this->sync($items, Otvod::class);
        $items = AnalcliData::all();
        $this->sync($items, Analysis::class);
        $command['run']=false;
        $command->save();
        return [];
    }

    private function sync($items, $model)
    {
        $all = [];
        $error = [];
        foreach ($items as $item) {
            try {
                $data = $model::transform($this->service, $item);
                $rule = $model::RULE;
                $rule = array_merge($rule, $this->GetRuleDoc($data));
                $validator = Validator::make($data, $rule);
                $data['validated'] = !$validator->fails();
//            if ($validator->fails()) {
//                dump($data);
//                dd($validator->failed());
//            }
                $model::create($data);
                $all[] = $data;
            } catch (\Exception $exception) {
                $error[] = $data;
                continue;
            }
        }
        if (!empty($all))
            $this->createLog($model::LOG_NAME . '_all', $all, $model);
        if (!empty($error))
            $this->createLog($model::LOG_NAME . '_bad', $error, $model);
    }

    public function sendCommand($start, $end)
    {
        //отправка команды чтобы сервис обновился
        $client = Http::post(config('aist.url') . '/start', [
            "startDate" => $start,
            "endDate" => $end
        ]);
        return [];
    }

    private function GetRuleDoc(&$item)
    {
        if (preg_match('/^(\d{3})$/', $item['document_serial'])) {
            $item['document_type'] = config('const.DocType.VNG');
            $rules = ['document_serial' => ['required', 'regex:/^(\d{3})$/u'],
                'document_number' => ['required', 'regex:/^(\d{1,7})$/u']];

        } elseif (preg_match('/[da-zA-Zа-яёА-ЯЁ]/', $item['document_serial'])) {
            $item['document_type'] = config('const.DocType.INPassport');
            $rules = ['document_serial' => ['required', 'regex:/^([\da-zA-Zа-яёА-ЯЁ]{1,5})$/u'],
                'document_number' => ['required', 'regex:/^(\d{1,7})$/u']];

        } else {
            $item['document_type'] = config('const.DocType.Passport');
            $rules = ['document_serial' => ['required', 'regex:/^(\d{4})$/u'],
                'document_number' => ['required', 'regex:/^(\d{6})$/u']];
        }

        return $rules;
    }

    public function createLog($name, $list, $model)
    {
        $fields = $model::LOG_FIELD;
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
}

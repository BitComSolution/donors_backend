<?php

namespace App\Services;

use App\Models\Analysis;
use App\Models\DB;
use App\Models\EventLog;
use App\Models\Logs;
use App\Models\Osmotr;
use App\Models\Personas;
use App\Models\Scheduled;
use App\Models\Source;
use App\Models\TWO\AnalcliData;
use App\Models\TWO\BloodData;
use App\Models\TWO\OsmotrData;
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
        $this->now = Carbon::now()->format("Y_m_d-H_i_s");
        $status = Scheduled::where('run', true)->first();
        if (!is_null($status)) {
            return false;
        }
        $command = Scheduled::where('title', 'aist')->first();
        $command['run'] = true;
        $command->save();
        try {
            $this->service = new DataService;
            //очиска бд
            Source::truncate();
            Otvod::truncate();
            Analysis::truncate();
            Osmotr::truncate();
            Personas::truncate();
            EventLog::create(['type' => 'ready']);
//        получение новых записей
            $items = BloodData::all();
            $this->createLogAist(Source::LOG_NAME, Source::LOG_FIELD_CONVERT, $items);
            $this->sync($items, Source::class);
            $items = AnalcliData::all();
            $this->createLogAist(Analysis::LOG_NAME, Analysis::LOG_FIELD_CONVERT, $items);
            $this->sync($items, Analysis::class);
            $items = OsmotrData::all();
            $this->createLogAist(Osmotr::LOG_NAME, Osmotr::LOG_FIELD_CONVERT, $items);
            $this->sync($items, Osmotr::class);
            $items = OtvodAist::all();
            $this->createLogAist(Otvod::LOG_NAME, Otvod::LOG_FIELD_CONVERT, $items);
            $this->sync($items, Otvod::class);
        } finally {
            $command['run'] = false;
            $command->save();
        }
        return [];
    }

    private function sync($items, $model)
    {
        $handle_success = LogService::createFile('validator', $this->now . '_' . $model::LOG_NAME . '_success', $model::LOG_FIELD_VALIDATOR);
        $handle_bad = LogService::createFile('validator', $this->now . '_' . $model::LOG_NAME . '_bad', $model::LOG_FIELD_VALIDATOR);
        foreach ($items as $item) {
            try {
                $data = $model::transform($this->service, $item);
                $rule = $model::RULE;
                $rule = array_merge($rule, $this->GetRuleDoc($data));
                $validator = Validator::make($data, $rule);
                $data['validated'] = !$validator->fails();
                if ($validator->fails()) {
                    $data['error'] = $validator->failed();
                    LogService::addLine($handle_bad, $model::LOG_FIELD_VALIDATOR, $data + ['message' => 'Ошибка валидации']);
                } else {
                    LogService::addLine($handle_success, $model::LOG_FIELD_VALIDATOR, $data + ['message' => 'Без ошибок']);
                }
                $model::create($data);
                $pers = Personas::where('card_id', $data['card_id'])->first();
                if (is_null($pers))
                    Personas::create($data);
                else {
                    $data['validated'] = $data['validated'] && $pers['validated'];
                    $pers->update($data);
                }
            } catch (\Exception $exception) {
                $data['message'] = $exception->getMessage();
                LogService::addLine($handle_bad, $model::LOG_FIELD_VALIDATOR, $data);
                continue;
            }
        }
        LogService::closeFile($handle_success);
        LogService::closeFile($handle_bad);
    }

    public function sendCommand($start, $end)
    {
        $record = DB::where('active', true)->first();
        if (!$record) return 0;
        $url_aist = $record->url_aist;
        //отправка команды чтобы сервис обновился
        $client = Http::post($url_aist . '/start', [
            "startDate" => $start,
            "endDate" => $end
        ]);
        return [];
    }

    public static function getStatus()
    {
        $record = DB::where('active', true)->first();
        if (!$record) return 0;

        try {
            $url_aist = $record->url_aist;
            $response = Http::timeout(5)->get($url_aist . '/status');

            return (int)(
                $response->successful()
                && strpos($response->body(), 'Get data from') !== false
            );
        } catch (\Exception $e) {
            return 0;
        }
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

    public function createLogAist($name, $fields, $data)
    {
        $handle = LogService::createFile('converter', $this->now . '_' . $name . '_success', $fields);
        foreach ($data as $item) {
            LogService::addLine($handle, $fields, $item);
        }
        LogService::closeFile($handle);
    }

    public function failLog()
    {
        EventLog::create(['type' => 'fail']);
    }
}

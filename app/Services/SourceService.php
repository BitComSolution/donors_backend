<?php

namespace App\Services;

use App\Models\BloodData;
use App\Models\Donors;
use App\Models\EventLog;
use App\Models\Logs;
use App\Models\Source;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SourceService
{
    public function dbSynchronize()
    {
        EventLog::create(['type' => 'ready']);
        $saved = Donors::all();
        $mysql = BloodData::whereNotIn('card_id', $saved->pluck('id_mysql'))->get()->values();
        $all = [];
        $error = [];
        foreach ($mysql as $donor) {
            $data = $donor->getOriginal();
            unset($data['Id']);
            try {
                $validator = Validator::make($data, Source::RULE);
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

    public function requestMS()
    {
        $source = Source::all();
        foreach ($source->pluck('card_id') as $id) {
            Donors::create(['id_mysql' => $id]);
        }
//ОТПРАВКА НА СЕРВИС конечный
        $source->each->delete();
        //отправить данные на сервис
    }

    public function createLog($name, $list)
    {
        $fields = Logs::FIELD;
        $csvFileName = $name . '_conv_' . Carbon::now()->toDateTimeString() . '.csv';
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

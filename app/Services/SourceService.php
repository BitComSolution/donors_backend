<?php

namespace App\Services;

use App\Models\BloodData;
use App\Models\Donors;
use App\Models\Logs;
use App\Models\Source;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class SourceService
{
    public function dbSynchronize()
    {
        $saved = Donors::all();
        $mysql = BloodData::whereNotIn('card_id', $saved->pluck('id_mysql'))->get()->values();
        $all = [];
        $error = [];
        foreach ($mysql as $donor) {
            $data = $donor->getOriginal();
            unset($data['Id']);
            try {
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

    public function sendCommand()
    {
        $client = Http::get(config('track.api_key'), []);
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
        $csvFileName = $name . '_conv_' . Carbon::now()->toDateString() . '.csv';
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

}

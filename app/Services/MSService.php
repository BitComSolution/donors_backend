<?php

namespace App\Services;


use App\Models\Analysis;
use App\Models\Donors;
use App\Models\MS\Donations;
use App\Models\MS\DonationTypes;
use App\Models\MS\Examinations;
use App\Models\MS\IdentityDocs;
use App\Models\MS\MedicalTestResults;
use App\Models\MS\MedicalTypes;
use App\Models\MS\Organizations;
use App\Models\MS\PersonAddresses;
use App\Models\MS\PersonCards;
use App\Models\Otvod;
use App\Models\Source;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MSService
{
    public function send()
    {
//        //перенос всех записей в мс
        $source = Source::where("validated", true)->get();
        foreach ($source as $item) {
            try {
                Donors::create(['id_mysql' => $item['card_id']]);
                $this->createRecord($item);
            } catch (\Exception $exception) {
                Log::channel('ms')->info('Error ' . $item['card_id'] . '  ' . $exception->getMessage());
//                dump($exception->getMessage());
            }
        }
        $source = Source::all();
        $source->each->delete();
//        //перенос отводов
        $otvod = Otvod::where("validated", true)->get();
        foreach ($otvod as $item) {
            try {
                $this->createRecord($item);
            } catch (\Exception $exception) {
                Log::channel('ms')->info('Error otvod' . $item['card_id'] . '  ' . $exception->getMessage());
//                dump($exception->getMessage());
            }
        }
        $source = Otvod::all();
        $source->each->delete();
        //перенос анализов
        $analysis = Analysis::where("validated", true)->get();
        $this->medicaltypes = MedicalTypes::all()->pluck('Id', 'Code');
        foreach ($analysis as $item) {
            try {
                $this->createRecordAnalysis($item);
            } catch (\Exception $exception) {
                Log::channel('ms')->info('Error analysis' . '  ' . $exception->getMessage());
//                dump($exception->getMessage());
            }
        }
        $source = Analysis::all();
        $source->each->delete();
        return true;

    }

    private function createBody($item, $fields = [])
    {
        $body = [];
        foreach ($fields as $field) {
            $body[$field['ms']] = (!isset($field['default'])) ? $item[$field['aist']] : config($field['default']);
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
        $item = $this->createExaminations($item);
        //работа с анализами
        $item = $this->createMedicalTestResults($item);
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
        $card = PersonCards::where('Snils', $item['snils'])->first();
        if (is_null($card)) {
            $item = $this->UniqueIdCreate(PersonCards::class, $item);
        } else {
            $item['card_id'] = $card['UniqueId'];
            $card->update($this->createBody($item, PersonCards::Fields));
        }
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
        $item = $this->UniqueIdCreate(Examinations::class, $item);
        return $item;
    }

    private function createMedicalTestResults($item)
    {
        $types = config('const.MedicalTestResults.types');
        foreach ($types as $type) {
//            $item['test_valid'] = true;//написать проверку что значение подходит
            $item['test_value'] = $item[$type];
            $item['test_type_id'] = $this->medicaltypes[strtoupper($type)];
            $item = $this->UniqueIdCreate(MedicalTestResults::class, $item);
        }
        return $item;
    }

    private function UniqueIdCreate($model, $item)//проверить
    {
        $model_id = $model::orderByDesc('UniqueId')->limit(1)->first();
        if (is_null($model_id) || $model_id['UniqueId'] < config('const.' . $model::NAME . '.UniqueIdMIN'))
            $item[$model::ID] = config('const.' . $model::NAME . '.UniqueIdMIN');
        else {
            $item[$model::ID] = $model_id['UniqueId'] + 1;
        }
        $model::firstOrCreate($this->createBody($item, $model::Fields));
        return $item;
    }
}

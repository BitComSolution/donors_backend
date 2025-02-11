<?php

namespace App\Services;


use App\Models\Donors;
use App\Models\MS\Donations;
use App\Models\MS\DonationTypes;
use App\Models\MS\IdentityDocs;
use App\Models\MS\Organizations;
use App\Models\MS\PersonAddresses;
use App\Models\MS\PersonCards;
use App\Models\Otvod;
use App\Models\Source;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MSService
{
    protected $organizations;

    protected $donation_types;

    public function send()
    {
        $source = Source::where("validated", true)->get();
        $this->donation_types = DonationTypes::all()->pluck('UniqueId', 'Code');
        $this->organizations = Organizations::all()->pluck('UniqueId', 'OrgCode');
        foreach ($source as $item) {
            try {
                $this->createRecord($item);
                Donors::create(['id_mysql' => $item['card_id']]);
            } catch (\Exception $exception) {
                Log::channel('ms')->info('Error ' . $item['card_id'] . '  ' . $exception->getMessage());
//                dump($exception->getMessage());
            }
        }
        $source = Source::all();
        $source->each->delete();
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

    private function convertFields($item)
    {
        if (!is_null($item['gender'])) {
            $item['gender'] = ("М" == $item['gender']) ? 1 : 2;
        } elseif (!is_null($item['middlename'])) {
            $item['gender'] = (substr(strtolower($item['middlename']), -2) === 'ич') ? 1 : 2;
        }
        $item['address'] = str_replace('Прочие регионы, ', "", $item['address']);
        $item['birth_date'] = Carbon::parse($item['birth_date'])->format('Y-d-m H:i:s');
        $item['created'] = Carbon::parse($item['created'])->format('Y-d-m H:i:s');
        $item['LastModifiedDate'] = Carbon::now()->addHours(3)->format('Y-d-m H:i:s');
        if ("+" == $item['rh_factor'])
            $item['rh_factor'] = 1;
        if ("-" == $item['rh_factor'])
            $item['rh_factor'] = -1;
        if ("+" == $item['kell'])
            $item['kell'] = 1;
        if ("-" == $item['kell'])
            $item['kell'] = -1;
        $item['OrgId'] = $this->organizations[$item['kod_128']];

        if (isset($item['donation_org_128']))
            $item['donation_org_128'] = $this->organizations[$item['donation_org_128']];
        if (isset($item['donation_date']))
            $item['donation_date'] = Carbon::parse($item['donation_date'])->format('Y-d-m H:i:s');
        if (isset($item['research_date']))
            $item['research_date'] = Carbon::parse($item['research_date'])->format('Y-d-m H:i:s');
        if ($item['document_type'] == config('const.DocType.VNG')) {
            $document = $item['document_serial'] . $item['document_number'];
            $item['document_serial'] = mb_substr($document, 0, 2);
            $item['document_number'] = mb_substr($document, 2, 100);
        }

        $item['phenotype'] = intval($item['phenotype']);

        return $item;
    }

    private function createRecord($item)
    {
        if ($item['kod_128'] != 0) {
            $item = $this->convertFields($item);
            if (isset($item['address']))
                $item['PersonAddresses'] = PersonAddresses::firstOrCreate($this->createBody($item, PersonAddresses::Fields))['UniqueId'];
            $item['IdentityDocs'] = IdentityDocs::firstOrCreate($this->createBody($item, IdentityDocs::Fields))['UniqueId'];

            $card = PersonCards::where('Snils', $item['snils'])->first();
            if (is_null($card)) {
                $pers_card = PersonCards::orderByDesc('UniqueId')->limit(1)->first();
                if (is_null($pers_card) || $pers_card['UniqueId'] < config('const.PersonCards.UniqueIdMIN'))
                    $item['card_id'] = config('const.PersonCards.UniqueIdMIN');
                else
                    $item['card_id'] = $pers_card['UniqueId'] + 1;
                $item['PersonCards'] = PersonCards::create($this->createBody($item, PersonCards::Fields));
            } else {
                $item['card_id'] = $card['UniqueId'];
                $card->update($this->createBody($item, PersonCards::Fields));
            }
            if (isset($item['donation_id'])) {
                $types = config('const.DonationType');
                if (isset($types[$item['donation_type_id']])) {
                    $item['donation_type_id'] = $types[$item['donation_type_id']];
                }
                $item['DonationTypeId'] = $this->donation_types[$item['donation_type_id']];
                $donation = Donations::where('Barcode', $item['donation_barcode'])->first();
                if (is_null($donation)) {
                    $donation_id = Donations::orderByDesc('UniqueId')->limit(1)->first();
                    if (is_null($donation_id) || $donation_id['UniqueId'] < config('const.Donations.UniqueIdMIN'))
                        $item['donation_id'] = config('const.Donations.UniqueIdMIN');
                    else {
                        $item['donation_id'] = $donation_id['UniqueId'] + 1;
                    }
                    $item['Donations'] = Donations::firstOrCreate($this->createBody($item, Donations::Fields));
                }
            }
        }
        return $item;
    }
}

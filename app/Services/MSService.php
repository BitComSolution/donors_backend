<?php

namespace App\Services;


use App\Models\Donors;
use App\Models\MS\Donations;
use App\Models\MS\DonationTypes;
use App\Models\MS\IdentityDocs;
use App\Models\MS\PersonAddresses;
use App\Models\MS\PersonCards;
use App\Models\Source;
use Carbon\Carbon;

class MSService
{
    public function send()
    {
        $source = Source::where("validated", true)->get();
        $don_type = DonationTypes::all()->pluck('UniqueId', 'Code');
        foreach ($source as $item) {
            try {
                $item['gender'] = ("М" == $item['gender']) ? 1 : 2;
                $item['birth_date'] = Carbon::parse($item['birth_date'])->format('Y-d-m H:i:s');
                $item['created'] = Carbon::parse($item['created'])->format('Y-d-m H:i:s');
                $item['donation_date'] = Carbon::parse($item['donation_date'])->format('Y-d-m H:i:s');
                $item['research_date'] = Carbon::parse($item['research_date'])->format('Y-d-m H:i:s');
                $item['DonationTypeId'] = $don_type[$item['donation_type_id']];
                if (!isset($item['address']) && !is_null($item['address']))
                    $item['PersonAddresses'] = PersonAddresses::firstOrCreate($this->createBody($item, PersonAddresses::Fields))['UniqueId'];
                $item['IdentityDocs'] = IdentityDocs::firstOrCreate($this->createBody($item, IdentityDocs::Fields));

                $card = PersonCards::where('UniqueId', $item['card_id'])->first();
                if (is_null($card))
                    $item['PersonCards'] = PersonCards::create($this->createBody($item, PersonCards::Fields));
//            else//обновление записей надо сделать
//                $card->update($this->createBody($item, PersonCards::Fields));
                $donation = Donations::where('UniqueId', $item['donation_id'])->first();
                if (is_null($donation))
                    $item['Donations'] = Donations::firstOrCreate($this->createBody($item, Donations::Fields));
                Donors::create(['id_mysql' => $item['card_id']]);
            } catch (\Exception $exception) {
//                dump($exception->getMessage());
            }
        }
        $source = Source::all();
        $source->each->delete();
        return true;

    }

    private function createBody($item, $fields = [])
    {
        $body = [];
        foreach ($fields as $field) {
            $body[$field['ms']] = (!isset($field['default'])) ? $item[$field['aist']] : $field['default'];
        }
        return $body;
    }
}

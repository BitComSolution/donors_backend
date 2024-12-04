<?php

namespace App\Services;


use App\Models\Donors;
use App\Models\MS\Donations;
use App\Models\MS\DonationTypes;
use App\Models\MS\IdentityDocs;
use App\Models\MS\Organizations;
use App\Models\MS\PersonAddresses;
use App\Models\MS\PersonCards;
use App\Models\Source;
use Carbon\Carbon;

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
                $item = $this->convertFields($item);
                if (isset($item['address']))
                    $item['PersonAddresses'] = PersonAddresses::firstOrCreate($this->createBody($item, PersonAddresses::Fields))['UniqueId'];
                $item['IdentityDocs'] = IdentityDocs::firstOrCreate($this->createBody($item, IdentityDocs::Fields))['UniqueId'];

                $card = PersonCards::where('UniqueId', $item['card_id'])->first();
                if (is_null($card))
                    $item['PersonCards'] = PersonCards::create($this->createBody($item, PersonCards::Fields));
                else
                    $card->update($this->createBody($item, PersonCards::Fields));
                if (isset($item['donation_id'])) {
                    $donation = Donations::where('UniqueId', $item['donation_id'])->first();
                    if (is_null($donation))
                        $item['Donations'] = Donations::firstOrCreate($this->createBody($item, Donations::Fields));
                }
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

    private function convertFields($item)
    {
        $item['gender'] = ("М" == $item['gender']) ? 1 : 2;
        $item['birth_date'] = Carbon::parse($item['birth_date'])->format('Y-d-m H:i:s');
        $item['created'] = Carbon::parse($item['created'])->format('Y-d-m H:i:s');
        $item['donation_date'] = Carbon::parse($item['donation_date'])->format('Y-d-m H:i:s');
        $item['research_date'] = Carbon::parse($item['research_date'])->format('Y-d-m H:i:s');
        $item['DonationTypeId'] = $this->donation_types[$item['donation_type_id']];
        $item['rh_factor'] = ("+" == $item['rh_factor']) ? 1 : -1;
        $item['kell'] = ("+" == $item['kell']) ? 1 : -1;
        $item['OrgId'] = $this->organizations[$item['kod_128']];
        $item['donation_org_128'] = $this->organizations[$item['donation_org_128']];
        $phenotype = '';
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
                default:
                {
                    $phenotype .= 0;
                }
            }
        }
        $item['phenotype'] = intval($phenotype);

        return $item;
    }
}

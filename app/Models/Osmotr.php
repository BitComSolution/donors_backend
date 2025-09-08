<?php

namespace App\Models;

use App\Models\TWO\AnalcliData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Osmotr extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $guarded = [];

    const RULE = [
//        'card_id' => ['required'],
//        'lastname' => ['required', 'regex:/^[А-Я]{1}[А-Яа-я\-]+/u'],
//        'name' => ['required', 'regex:/^[А-Я]{1}[А-Яа-я\-]+/u'],
//        'middlename' => ['regex:/^[А-Я]{1}[А-Яа-я\- ]+/u'],
//        'gender' => [''],
//        'birth_date' => ['required', 'date_format:dd.mm.yyyy'],//как в тз
//        'birth_date' => ['required', 'date_format:Y-m-d'],//как в бд
        'snils' => ['required', 'regex:/^(\d{11})$/u'],
////в исходной базе лежат не правильные данные /^\d{3}.\d{3}.\d{3}.\d{2}/u'
//        'blood_group' => ['integer', 'between:1,4'],
//        'rh_factor' => ['regex:/^[+-]{1}/u'],
//        'kell' => ['regex:/^[+-]{1}/u'],
//        'phenotype' => ['regex:/^[+ -]{6,7}/u'],
//        'document' => ['required'],
//        'donation_id' => ['required', 'regex:/^(\d{12})$/u'],
//        'donor_card_id' => ['required'],
//        'donation_org_id' => ['required'],
//        'donation_type_id' => ['required'],
//        'donation_date' => ['required', 'date_format:dd.mm.yyyy'],//как в тз
//        'donation_date' => ['required', 'date_format:Y-m-d'],//как в бд
//        'donation_barcode' => ['required', 'regex:/^(\d{12})$/u'],
//        'donation_volume' => ['required', 'between:1,800'],
//        'address' => ['regex:/^[А-Яа-я\- .\d\/]+/u'],//в исходной базе лежат не правильные данные
//        'document_type' => ['required'],
//        'document_serial' => ['required', 'regex:/^(\d{4})$/u'],
//        'document_number' => ['required', 'regex:/^(\d{6})$/u'],
//        'anti_erythrocyte_antibodies' => ['regex:/^[0+1-]{1}$/u'],
        'OrgId' => ['required'],
    ];
    const TRANS_FIELDS = [
        'snils',
        'document_serial',
        'document_number'
    ];
    const SYMBOLS =
        [' ', '-', '.', '_'];

    const LOG_NAME = 'osmotr';

    const LOG_FIELD = [
        'card_id',
        'name',
        'middlename',
        'gender',
        'birth_date',
        'validated'
    ];
    protected $casts = [
        'error' => 'array',
    ];

    const DATE_FIELDS = ['birth_date', 'date'];

    public static function transform($service, $item)
    {
        return $service->OsmotrConvert($item->getOriginal());
    }

    const TYPES =
        [
            'AD1' => 'ad_sis',
            'AD2' => 'ad_dias',
            'puls' => 'puls',
            'T' => 'temp',
            'VLM' => 'doza',
            'ves' => 'ves',
            'rost' => 'rost',
        ];
}

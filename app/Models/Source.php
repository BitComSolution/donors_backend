<?php

namespace App\Models;

use App\Services\DataService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $guarded = [];

    const RULE = [
        'card_id' => ['required'],
        'lastname' => ['required', 'regex:/^[А-ЯЁ][А-ЯёЁа-я-]+$/u'],
        'name' => ['required', 'regex:/^[А-ЯЁ][А-ЯёЁа-я-]+$/u'],
        'middlename' => ['regex:/^(?:[А-ЯЁ][А-ЯёЁа-я -]+)?$/u'],
//        'gender' => [''],
        'birth_date' => ['required', 'date_format:Y-d-m H:i:s'],//как в бд
        'snils' => ['required', 'regex:/^(\d{11})$/u'],
        'blood_group' => ['integer', 'between:1,4'],
        'rh_factor' => ['regex:/^[\d-]{1,2}/u'],
        'kell' => ['regex:/^[\d-]{1}/u'],
        'phenotype' => ['regex:/^\d{0,10}/u'],
        'document' => ['required'],
        'donation_id' => ['required', 'regex:/^(\d{12})$/u'],
        'donor_card_id' => ['required'],
        'donation_org_id' => ['required'],
        'donation_type_id' => ['required'],
        'donation_date' => ['required', 'date_format:Y-d-m H:i:s'],//как в бд
        'donation_barcode' => ['required', 'regex:/^(\d{12})$/u'],
        'donation_volume' => ['required', 'between:1,800'],
//        'address' => ['regex:/^[А-Яа-я\- .\d\/]+/u'],//в исходной базе лежат не правильные данные
        'document_type' => ['required'],
        'anti_erythrocyte_antibodies' => ['regex:/^[0+1-]{1}$/u'],
        'OrgId' => ['required'],
    ];
    const TRANS_FIELDS = [
        'snils',
        'document_serial',
        'document_number'
    ];
    const SYMBOLS =
        [' ', '-', '.', '_'];

    protected $casts = [
        'error' => 'array',
    ];

    const LOG_NAME = 'main';

    const LOG_FIELD = [
        'card_id',
        'org_name',
        'name',
        'middlename',
        'gender',
        'birth_date',
        'donation_id',
        'donation_org_id',
        'donation_date',
        'validated'
    ];

    const DATE_FIELDS = [
        'birth_date', 'created', 'donation_date',
        'research_date', 'ex_started', 'ex_removed',
        'ex_created', 'research_date_2', 'created_2'
    ];

    public static function transform($service, $item)
    {
        return $service->SourceConvert($item->getOriginal());
    }

    const TYPES =
        [
            'vich',
            'hbs',
            'sif',
            'hcv',
            'pcr',
            'anti_a',
            'anti_b',
            'hla',
            'gra',
            'grb',
            'mn',
            'ss',
            'fy',
            'lu',
            'le',
            'jk',
            'kp',
            'pi',
            'pcrraw',
            'vichraw',
            'hbsraw',
            'sifraw',
            'hcvraw',
        ];
}

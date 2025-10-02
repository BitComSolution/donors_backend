<?php

namespace App\Models;

use App\Models\TWO\AnalcliData;
use App\Services\DataService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $guarded = [];

    const RULE = [
        'lastname' => ['required', 'regex:/^[А-ЯЁ][А-ЯёЁа-я-]+$/u'],
        'name' => ['required', 'regex:/^[А-ЯЁ][А-ЯёЁа-я-]+$/u'],
        'middlename' => ['regex:/^(?:[А-ЯЁ][А-ЯёЁа-я -]+)?$/u'],
        'snils' => ['required', 'regex:/^(\d{11})$/u'],
//        'rh_factor' => ['regex:/^[\d-]{1,2}/u'],
//        'kell' => ['regex:/^[\d-]{1}/u'],
        'birth_date' => ['required', 'date_format:Y-m-d H:i:s'],
        'phenotype' => ['integer', 'regex:/^\d{0,10}/u'],

    ];
    const TRANS_FIELDS = [
        'snils',
        'document_serial',
        'document_number'
    ];
    const SYMBOLS =
        [' ', '-', '.', '_'];

    const LOG_NAME = 'analyzes';

    const LOG_FIELD_CONVERT = [
        'name', 'middlename', 'lastname', 'snils',
        'message'
    ];
    const LOG_FIELD_VALIDATOR = [
        'name', 'middlename', 'lastname', 'snils',
        'message'
    ];
    const LOG_FIELD_MS = [
        'name', 'middlename', 'lastname', 'snils',
        'message'
    ];

    const DATE_FIELDS = [
        'birth_date', 'analysis_date',

    ];
    protected $casts = [
        'error' => 'array',
    ];

    public static function transform($service, $item)
    {
        return $service->AnalysisConvert($item->getOriginal());
    }

    const TYPES =
        [
            'hb' => 'hb',
            'soe' => 'soe',
            'belok' => 'belok',
            'abo' => 'abo',
            'trom' => 'trom',
            'erit' => 'erit',
            'cwet' => 'cwet',
            'leyk' => 'leyk',
            'palja' => 'palja',
            'segja' => 'segja',
            'eos' => 'eos',
            'bas' => 'bas',
            'lim' => 'lim',
            'mon' => 'mon',
            'plkl' => 'plkl',
            'miel' => 'miel',
            'meta' => 'meta',
            'svrn' => 'svrn',
            'krtok' => 'krtok',
            'gemat' => 'gemat',
            'mch' => 'mch',
            'mchc' => 'mchc',
            'ret' => 'ret',
            'mcv' => 'mcv',
            'svrk' => 'svrk',
            //                'num',
            'BELK_FR' => 'bel_fr',
        ];
}


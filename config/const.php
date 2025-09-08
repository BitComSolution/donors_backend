<?php

return [
    'PersonCards' =>
        [
            'BirthDateIsUndefined' => env('PersonCardsBirthDateIsUndefined', false),
            'IsAgree' => env('PersonCardsIsAgree', true),
            'IsDeleted' => env('PersonCardsIsDeleted', false),
            'IsMessageAgree' => env('PersonCardsIsMessageAgree', true),
        ],
    'IdentityDocs' =>
        [
            'DocType' => intval(env('IdentityDocsDocType', 1)),
        ],
    'Donations' =>
        [
            'IsDeleted' => env('DonationsIsDeleted', false),
            'ResultStatus' => intval(env('DonationsResultStatus', 0)),
        ],
    'DocType' =>
        [
            'Passport' => intval(env('Passport', 1)),
            'VNG' => intval(env('VNG', 7)),
            'INPassport' => intval(env('INPassport', 5)),
        ],
    'DonationType' =>
        [
            '001' => '001',
            '110' => '110',
            '117' => '110',
            '118' => '110',
            '125' => '129',
            '127' => '129',
            '129' => '129',
            '130' => '130',
            '136' => '130',
            '137' => '130',
            '230' => '130',
        ],
    'Examinations' =>
        [
            'HematologyResultType' => intval(env('ExaminationsHematologyResultType', 1)),
        ],
    'Deferrals' =>
        [
            'EpidControlInactive' => boolval(env('DeferralsEpidControlInactive', false)),
        ],
    //это для прода
//    'DonationType' =>
//        [
//            '001' => '001',
//            '002' => '001',
//            '003' => '001',
//            '110' => '110',
//            '111' => '110',
//            '117' => '210',
//            '118' => '110',
//            '119' => '119',
//            '120' => '12D',
//            '122' => '129',
//            '123' => '12D',
//            '124' => '12D',
//            '125' => '229',
//            '126' => '129',
//            '127' => '229',
//            '128' => '22D',
//            '129' => '129',
//            '130' => '130',
//            '133' => '230',
//            '135' => '130',
//            '136' => '130',
//            '137' => '230',
//            '140' => '140',
//            '141' => '240',
//            '142' => '140',
//            '143' => '140',
//            '144' => '240',
//            '214' => '210',
//            '218' => '218',
//            '228' => '228',
//            '230' => '230',
//            '240' => '240',
//            '320' => '320',
//        ]
];

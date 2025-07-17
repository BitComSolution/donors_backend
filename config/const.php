<?php

return [
    'PersonCards' =>
        [
            'CreateUserId' => intval(env('PersonCardsCreateUserId', -20)),
            'BirthDateIsUndefined' => env('PersonCardsBirthDateIsUndefined', false),
            'IsAgree' => env('PersonCardsIsAgree', true),
            'IsDeleted' => env('PersonCardsIsDeleted', false),
            'IsMessageAgree' => env('PersonCardsIsMessageAgree', true),
            'UniqueIdMIN' => intval(env('PersonCardsUniqueIdMIN', 400000000)),
        ],
    'IdentityDocs' =>
        [
            'DocType' => intval(env('IdentityDocsDocType', 1)),
        ],
    'Donations' =>
        [
            'DepartmentId' => intval(env('DonationsDepartmentId', 0)),
            'IsDeleted' => env('DonationsIsDeleted', false),
            'CreateUserId' => intval(env('DonationsCreateUserId', -20)),
            'ResultStatus' => intval(env('DonationsResultStatus', 0)),
            'UniqueIdMIN' => intval(env('DonationsUniqueIdMIN', 400000000)),
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
            'OrgId' => intval(env('ExaminationsOrgId', 7701)),
            'ExamType' => intval(env('ExaminationsExamType', 2)),
            'HematologyResultType' => intval(env('ExaminationsHematologyResultType', 1)),
            'UniqueIdMIN' => intval(env('ExaminationsUniqueIdMIN', 400000000)),
        ],
    'MedicalTestResults' =>
        [
            'types' => [
                'hb',
                'soe',
                'belok',
                'abo',
                'trom',
//                'num',
//                'bel_fr',
                'erit',
                'cwet',
                'leyk',
                'palja',
                'segja',
                'eos',
                'bas',
                'lim',
                'mon',
                'plkl',
                'miel',
                'meta',
                'svrn',
                'krtok',
                'gemat',
                'mch',
                'mchc',
                'ret',
                'mcv',
                'svrk',
            ],
            'UniqueIdMIN' => intval(env('ExaminationsUniqueIdMIN', 400000000)),
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

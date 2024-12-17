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
            'VNG' => intval(env('VNG', 2)),
            'INPassport' => intval(env('INPassport', 3)),
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
            '230' => '',
        ]
];

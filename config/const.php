<?php

return [
    'PersonCards' =>
        [
            'CreateUserId' => intval(env('PersonCardsCreateUserId', -20)),
            'BirthDateIsUndefined' => env('PersonCardsBirthDateIsUndefined', false),
            'IsAgree' => env('PersonCardsIsAgree', true),
            'IsDeleted' => env('PersonCardsIsDeleted', false),
            'IsMessageAgree' => env('PersonCardsIsMessageAgree', true),
        ],
    'IdentityDocs' =>
        [
            'DocType' => env('IdentityDocsDocType', 1),
        ],
    'Donations' =>
        [
            'DepartmentId' => intval(env('DonationsDepartmentId', 0)),
            'IsDeleted' => env('DonationsIsDeleted', false),
            'CreateUserId' => intval(env('DonationsCreateUserId', -20)),
            'ResultStatus' => intval(env('DonationsResultStatus', 0)),
        ]

];

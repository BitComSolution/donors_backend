<?php

return [
    'PersonCards' =>
        [
            'CreateUserId' => env('PersonCardsCreateUserId', -20),
            'BirthDateIsUndefined' => env('PersonCardsCreateUserId', false),
            'IsAgree' => env('PersonCardsCreateUserId', true),
            'IsDeleted' => env('PersonCardsCreateUserId', false),
            'IsMessageAgree' => env('PersonCardsCreateUserId', true),
        ],
    'IdentityDocs' =>
        [
            'DocType' => env('IdentityDocsCreateUserId', 1),
        ],
    'Donations' =>
        [
            'DepartmentId' => env('DonationsCreateUserId', 0),
            'IsDeleted' => env('DonationsCreateUserId', false),
            'CreateUserId' => env('DonationsCreateUserId', -20),
            'ResultStatus' => env('DonationsCreateUserId', 0),
        ]

];

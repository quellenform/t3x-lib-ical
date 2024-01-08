<?php

declare(strict_types=1);

use Quellenform\LibIcal\Middleware\IcalRequest;

return [
    'frontend' => [
        'quellenform/libical' => [
            'target' => IcalRequest::class,
            'after' => [
                'typo3/cms-frontend/authentication'
            ],
            'before' => [
                'typo3/cms-redirects/redirecthandler',
                'typo3/cms-frontend/base-redirect-resolver'
            ]
        ]
    ]
];

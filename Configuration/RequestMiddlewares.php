<?php

declare(strict_types=1);

use Quellenform\LibIcal\Middleware\IcalRequest;

return [
    'frontend' => [
        'quellenform/libical' => [
            'target' => IcalRequest::class,
            'after' => [
                'typo3/cms-redirects/redirecthandler',
            ]
        ]
    ]
];

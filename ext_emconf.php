<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'TYPO3 Library: iCalendar',
    'description' => 'Download database-records as calendar items (VEVENT)',
    'category' => 'services',
    'state' => 'beta',
    'clearcacheonload' => true,
    'author' => 'Stephan Kellermayr',
    'author_email' => 'stephan.kellermayr@gmail.com',
    'author_company' => 'quellenform.at - MULTIMEDIA ART DESIGN',
    'version' => '0.3.0',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5-12.4.99'
        ],
        'conflicts' => [],
        'suggests' => []
    ],
    'autoload' => [
        'psr-4' => ['Quellenform\\LibIcal\\' => 'Classes']
    ]
];

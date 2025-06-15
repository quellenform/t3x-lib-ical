<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'TYPO3 Library: iCalendar',
    'description' => 'Download database-records as calendar items (VEVENT)',
    'category' => 'services',
    'state' => 'beta',
    'clearcacheonload' => true,
    'author' => 'Stephan Kellermayr',
    'author_email' => 'typo3@quellenform.at',
    'author_company' => 'Kellermayr KG',
    'version' => '0.5.0',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-13.9.99'
        ],
        'conflicts' => [],
        'suggests' => []
    ]
];

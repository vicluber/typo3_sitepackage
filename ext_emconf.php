<?php

/**
 * Extension Manager/Repository config file for ext "suedbahnhotel_website".
 */
$EM_CONF[$_EXTKEY] = [
    'title' => 'Suedbahnhotel Website',
    'description' => 'A sitepackage for the website suedbahnhotel.at',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.5.99',
            'fluid_styled_content' => '11.5.0-11.5.99',
            'rte_ckeditor' => '11.5.0-11.5.99',
            'news' => '9.0.0-9.9.99',
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Hebotek\\SuedbahnhotelWebsite\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Hebotek',
    'author_email' => 'support@hebotek.at',
    'author_company' => 'Hebotek',
    'version' => '1.0.0',
];

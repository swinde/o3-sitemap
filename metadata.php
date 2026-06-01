<?php

$sMetadataVersion = '2.0';
$aModule          = [
    'id'          => 'swinde_sitemap',
    'title'       => '<strong>Sitemap generator</strong>',
    'description' => [
        'de' => 'Erstellt Sitemap',
        'en' => 'Generates Sitemap',
    ],
    'thumbnail'   => '',
    'version'     => '1.1.0',
    'author'      => 'Hleb Prakhnitski, Steffen Winde',
    'email'       => '',
    'url'         => 'https://github.com/swinde/o3-sitemap',
    'extend'      => [],
    'blocks'      => [],
    'settings'    => [
        [
            'group' => 'main',
            'name'  => 'swinde_sitemap_exclude',
            'type'  => 'aarr',
            'value' => '',
            'label' => [
                'de' => 'Ausgeschlossene URLs',
                'en' => 'Excluded URLs',
            ],
            'hint'  => [
                'de' => 'Geben Sie hier die URLs an, die von der Sitemap ausgeschlossen werden sollen. Jede URL sollte in einer neuen Zeile stehen.',
                'en' => 'Enter the URLs to be excluded from the sitemap here. Each URL should be on a new line.',
            ],
        ],
        
    ],
];

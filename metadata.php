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
            'group' => 'swSitemap',
            'name' => 'vtWithdrawalCaptchaSitekey',
            'type' => 'str',
            'value' => '',
            'position' => 0
        ]
    ],
];

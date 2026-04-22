<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@bootstrapexcel'   => '@vendor/phpoffice/phpspreadsheet/src/Bootstrap.php',
        '@firmdig'   => '',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'language' => 'es',
];

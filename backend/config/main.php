<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'id' => '',
    'name' => 'Gestión de CHGroup',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'gridview' => ['class' => 'kartik\grid\Module'],
     // 'rbac' => [
     //        'class' => 'yii2mod\rbac\Module',
     //    ],
        'admin' => [
            'class' => 'mdm\admin\Module',
             // 'layout' => 'left-menu',
            'mainLayout' => '@app/views/layouts/main.php',
        ]
    ],
    'components' => [
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'currencyCode' => 'BS'
        ],
        // 'authManager' => [
        //     'class' => 'yii\rbac\DbManager',
        //     'defaultRoles' => ['guest', 'user'],
        // ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // 'defaultRoles' => ['guest', 'user'],
        ],
        'as access' => [
            'class' => 'mdm\admin\components\AccessControl',
            'allowActions' => [
                'site/*',
                'admin/*',
                'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
            ]
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],





        'user' => [
            'identityClass' => 'common\models\User',
            // 'enableAutoLogin' => true,
            'enableSession' => true,
        'authTimeout' => 3600, // auth expire 
        // 'authTimeout' => 3600, // auth expire 
        'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
    ],
    'session' => [
        'class' => 'yii\web\Session',
        'cookieParams' => ['httponly' => true, 'lifetime' => 3600 * 4],
        'timeout' => 3600, //session expire
        // 'timeout' => 3600*4, //session expire
        'useCookies' => true,
        'name' => 'advanced-backend',
    ],



      /*  'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
*/

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

     /*   'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'rules' => [
            'dashboard' => 'dashboard/index',
        ],
    ],*/

        // 'urlManager' => [
        //     'enablePrettyUrl' => true,
        //     'showScriptName' => false,
        //     'rules' => [
        //         ' '  =>  ' site / index ' ,
        //         ' <action> ' => ' sitio / <acción> ' ,
        //     ],
        // ],

    ],
    'params' => $params,
    'language' => 'es',
];

<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$routes = require __DIR__ . '/routes.php';
$modules = require __DIR__ . '/modules.php';

$config = [
    'id' => 'basic',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'brussens\maintenance\Maintenance',
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => $_ENV['COOKIE_VALIDATION_KEY'],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\modules\user\models\User',
            'loginUrl' => ['/login'],
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => $routes['error'],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'htmlLayout' => false,
            'textLayout' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => $_ENV['MAILER_USERNAME'],
                'password' => $_ENV['MAILER_PASSWORD'],
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => $routes,
        ],
    ],
    'modules' => $modules,
    'params' => $params,
    'container' => [
        'singletons' => [
            'brussens\maintenance\Maintenance' => [
                'class' => 'brussens\maintenance\Maintenance',
                'route' => $routes['maintenance'],
                'filters' => [
                    //Allowed routes filter. Your can allow debug panel routes.
                    [
                        'class' => 'brussens\maintenance\filters\RouteFilter',
                        'routes' => [
                            $routes['login'],
                            $routes['logout'],
                        ]
                    ],
                    // Allowed roles filter
                    /*[
                        'class' => 'brussens\maintenance\filters\RoleFilter',
                        'roles' => [
                            'administrator',
                        ]
                    ],*/
                    // Allowed IP addresses filter
                    /*[
                        'class' => 'brussens\maintenance\filters\IpFilter',
                        'ips' => [
                            '127.0.0.1',
                        ]
                    ],*/
                    //Allowed user names
                    [
                        'class' => 'app\models\MaintenanceCustomUserFilter', //Кастомная модель, т.к. была ошибка
                        'checkedAttribute' => 'username',
                        'users' => [
                            'admin',
                        ],
                    ]
                ],

            ],
            'brussens\maintenance\StateInterface' => [
                'class' => 'brussens\maintenance\states\FileState',
            ]
        ]
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;

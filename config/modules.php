<?php

return [
    'admin' => [
        'layout' => '@app/modules/admin/views/layouts/main',
        'class' => 'app\modules\admin\Module',
        'controllerNamespace' => 'app\modules\admin\controllers',
        'defaultRoute' => 'default/index',
        'modules' => [
            'settings' => [
                'class' => 'app\modules\settings\Module',
                'controllerNamespace' => 'app\modules\settings\controllers\backend',
                'viewPath' => '@app/modules/settings/views/backend',
            ],
            'logs_admin' => [
                'class' => 'app\modules\logs_admin\Module',
                'controllerNamespace' => 'app\modules\logs_admin\controllers\backend',
                'viewPath' => '@app/modules/logs_admin/views/backend',
            ],
            'user' => [
                'class' => 'app\modules\user\Module',
                'controllerNamespace' => 'app\modules\user\controllers\backend',
                'viewPath' => '@app/modules/user/views/backend',
            ],
            'page' => [
                'class' => 'app\modules\page\Module',
                'controllerNamespace' => 'app\modules\page\controllers\backend',
                'viewPath' => '@app/modules/page/views/backend',
            ],
        ]
    ],
    'main' => [
        'class' => 'app\modules\main\Module',
        'controllerNamespace' => 'app\modules\main\controllers\frontend',
        'viewPath' => '@app/modules/main/views/frontend',
    ],
    'user' => [
        'class' => 'app\modules\user\Module',
        'controllerNamespace' => 'app\modules\user\controllers\frontend',
        'viewPath' => '@app/modules/user/views/frontend',
    ],
];

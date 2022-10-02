<?php
require __DIR__ . '/../vendor/autoload.php';

// для предотвращения скачивания .env файла выносим его за пределы DOCUMENT_ROOT (/web/), т.е. в корень проекта
// если есть возможность, так же добавить запрет на доступ к .env файлу в конфиге веб сервера
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', (bool)$_ENV['YII_DEBUG']);
defined('YII_ENV') or define('YII_ENV', $_ENV['YII_ENV']);

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();

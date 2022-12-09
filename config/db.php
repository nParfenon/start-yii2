<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => 'utf8',
    'tablePrefix' => 'tbl_',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

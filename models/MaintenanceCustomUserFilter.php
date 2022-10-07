<?php

namespace app\models;

use brussens\maintenance\filters\UserFilter;

class MaintenanceCustomUserFilter extends UserFilter
{

    public function __construct(array $config = [])
    {
        parent::__construct(\Yii::$app->user, $config);
    }

}
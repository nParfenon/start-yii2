<?php

namespace app\modules\settings\models;

use yii\db\ActiveRecord;

class Settings extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%settings}}';
    }

    public static function getSettings()
    {
        return Settings::find()->asArray()->indexBy('field')->all();
    }

}

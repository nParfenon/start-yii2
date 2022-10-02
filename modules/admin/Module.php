<?php

namespace app\modules\admin;

use Yii;
use yii\filters\AccessControl;
use app\modules\user\models\User;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    /*public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function($rule,$action){
                            return Yii::$app->user->getId() === User::SUPER_ADMIN_ID;
                        },
                    ],
                ],

            ],
        ];
    }*/

}
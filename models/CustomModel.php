<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use app\modules\logs_admin\models\LogsAdmin;

class CustomModel extends ActiveRecord
{

    const EVENT_SAVE_LOG = 'save log';

    /**
     * Возвращает поля, которые не будут записаны в логи
     * @return array ignored attribute
     */
    public function ignoreAttributeLog() : array
    {
        return [
            'created_at',
            'updated_at',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at','updated_at'],'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->on(self::EVENT_SAVE_LOG, [new LogsAdmin(), 'saveLog'], ['insert' => $insert, 'changedAttributes' => $changedAttributes, 'this' => $this]);
    }

    /**
     * {@inheritdoc}
     */
    public function afterDelete()
    {
        parent::afterDelete();

        $this->on(self::EVENT_SAVE_LOG, [new LogsAdmin(), 'saveLog'], ['this' => $this,]);
    }

}

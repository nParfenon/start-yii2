<?php

namespace app\modules\page\models;

use app\models\CustomModel;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string $name
 * @property string $urn
 * @property string|null $redirect
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_image
 * @property int|null $active
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Page extends CustomModel
{

    const MAIN_PAGE_ID = 1;
    const MAIN_PAGE = '/';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $array = [
            [['name','urn'],'required'],

            [['name','urn','redirect'], 'string', 'max' => 50],
            ['meta_title', 'string' ,'max' => 60],
            ['meta_description', 'string' ,'max' => 150],

            [['active'],'integer'],

            ['urn', 'unique', 'targetClass' => self::class, 'message' => 'Такой "{attribute}" уже зарегестрирован'],

            [['name','urn','redirect','meta_title','meta_description'], 'trim'],

            [['meta_image'],'safe']
        ];

        return array_merge(parent::rules(), $array);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $array = [
            'id' => 'ID',
            'name' => 'Наименование',
            'urn' => 'Адрес',
            'redirect' => 'Редирект',
            'meta_title' => 'Мета заголовок',
            'meta_description' => 'Мета описание',
            'meta_image' => 'Мета изображение',
            'active' => 'Активный'
        ];

        return array_merge(parent::attributeLabels(), $array);
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if ($this->id === self::MAIN_PAGE_ID || $this->urn === self::MAIN_PAGE){
            if ($this->urn !== self::MAIN_PAGE){
                return false;
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function beforeDelete()
    {
        if ($this->id === self::MAIN_PAGE_ID || $this->urn === self::MAIN_PAGE){
            return false;
        }

        return parent::beforeDelete();
    }

    public static function getPage()
    {
        return Page::find()->where(['urn' => strtok($_SERVER['REQUEST_URI'],'?'), 'active' => true])->one();
    }

}

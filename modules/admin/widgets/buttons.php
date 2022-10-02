<?php
namespace app\modules\admin\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class buttons extends Widget
{

    public $btn;
    public $text;
    public $url;
    public $options;

    public static $widthColumn = '123';

    private static $buttons = [
        'view' =>  [
            'text' => '<i class="fa fa-eye"></i>',
            'options' => ['class' => 'btn btn-default btn-sm']
        ],
        'update' => [
            'text' => '<i class="fa fa-pencil"></i>',
            'options' => ['class' => 'btn btn-default btn-sm']
        ],
        'delete' => [
            'text' => '<i class="fa fa-trash"></i>',
            'options' => ['class' => 'btn btn-default btn-sm', 'data' => [
                'confirm' => 'Вы уверены, что хотите удалить данный элемент?',
                'method' => 'post',
            ]]
        ],
    ];

    public function init()
    {
        $this->btn = Html::a(
            self::$buttons[$this->btn]['text'],
            $this->url,
            self::$buttons[$this->btn]['options']
        );
    }

    public function run()
    {
        return $this->btn;
    }



}
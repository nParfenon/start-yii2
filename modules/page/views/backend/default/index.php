<?php

use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\modules\admin\widgets\buttons;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\page\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страницы';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="col-xs-12">
    <div class="box">
        <div class="box-body">

            <p>
                <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'name',
                    'urn',
                    'active:boolean',
                    [
                        'class' => ActionColumn::className(),
                        'buttons' => [
                            'view'   => function($url, $model, $key) { return buttons::widget(['btn' => 'view', 'url' => $url]); },
                            'update' => function($url, $model, $key) { return buttons::widget(['btn' => 'update', 'url' => $url]); },
                            'delete' => function($url, $model, $key) { return buttons::widget(['btn' => 'delete', 'url' => $url]); },
                        ],
                        'options' => ['style' => 'width:'.buttons::$widthColumn.'px;'],
                    ],
                ],
            ]); ?>

        </div>
    </div>
</div>



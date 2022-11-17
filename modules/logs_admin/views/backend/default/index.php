<?php

use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\modules\admin\widgets\buttons;
use app\modules\logs_admin\models\LogsAdmin;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\logs_admin\models\LogsAdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Журнал действий';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-body">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],
                    'id',
                    [
                        'attribute' => 'user_id',
                        'format' => 'text',
                        'value' => function ($model) {
                            return Html::encode($model->user->username);
                        },
                    ],
                    'place',
                    [
                        'attribute' => 'action',
                        'format' => 'text',
                        'value' => function ($model) {
                            return Html::encode($model::_ACTIONS[$model->action]);
                        },
                        'filter' => LogsAdmin::_ACTIONS
                    ],
                    [
                        'attribute' => 'created_at',
                        'filter' => DateRangePicker::widget([
                            'name' => 'created_at',
                            'attribute' => 'created_at',
                            'model' => $searchModel,
                            'startAttribute' => 'date_from',
                            'endAttribute' => 'date_to',
                            'convertFormat'=>true,
                            'readonly' => true,
                            'pluginOptions'=>[
                                'timePicker' => true,
                                'timePickerIncrement' => 15,
                                'locale'=>[
                                    'format' => 'Y-m-d H:i:s',
                                    //'separator'=>' to ',
                                ],
                            ]
                        ])
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'template' => '{view}',
                        'buttons' => [
                            'view'   => function($url, $model, $key) { return buttons::widget(['btn' => 'view', 'url' => $url]); },
                        ],
                        'options' => ['style' => 'width:41px;'],
                    ],
                ],
            ]); ?>


        </div>
    </div>
</div>


<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\logs_admin\models\LogsAdmin;

/* @var $this yii\web\View */
/* @var $model app\modules\logs_admin\models\LogsAdmin */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Журнал действий', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="col-xs-12">
    <div class="box">
        <div class="box-body">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'user_id',
                        'format' => 'text',
                        'value' => Html::encode($model->user->username ?? $model->user_id),
                    ],
                    'place',
                    [
                        'attribute' => 'action',
                        'format' => 'text',
                        'value' => Html::encode($model::_ACTIONS[$model->action]),
                    ],
                    [
                        'attribute' => 'details',
                        'format' => 'html',
                        'value' => $model::decodeDetails($model->details),
                    ],
                    'created_at',
                ],
            ]) ?>

        </div>
    </div>
</div>

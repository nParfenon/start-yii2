<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\logs_admin\models\LogsAdmin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-xs-12">
    <div class="box">
        <div class="box-body">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'user_id')->textInput() ?>

        <?= $form->field($model, 'action')->textInput() ?>

        <?= $form->field($model, 'details')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'created_at')->textInput() ?>

        <?= $form->field($model, 'updated_at')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */
/* @var $form yii\widgets\ActiveForm */

/*$auth = Yii::$app->authManager;
$roles = ArrayHelper::map($auth->getRoles(), 'name','name');
$useRole = ArrayHelper::map($auth->getRolesByUser($model->id),'name','name');*/
?>

<div class="col-xs-12">
    <div class="box">
        <div class="box-body">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'username')->textInput() ?>

            <?= $form->field($model, 'email')->textInput() ?>

            <?= $form->field($model, 'password')->textInput(['readonly' => !$model->isNewRecord]) ?>

            <?= $form->field($model, 'newPassword')->textInput(['readonly' => $model->isNewRecord]) ?>

            <?= $form->field($model, 'isAdmin')->checkbox() ?>

            <?= $form->field($model, 'created_at')->textInput(['disabled' => true]) ?>

            <?= $form->field($model, 'updated_at')->textInput(['disabled' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>

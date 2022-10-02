<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\page\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<div class="col-xs-12">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#main" data-toggle="tab" aria-expanded="false">Главная</a></li>
            <li><a href="#meta" data-toggle="tab" aria-expanded="true">Мета данные</a></li>
        </ul>

        <div class="tab-content">

            <div class="tab-pane active" id="main">

                <?= $form->field($model, 'name')->textInput() ?>

                <?= $form->field($model, 'urn')->textInput() ?>

                <?= $form->field($model, 'redirect')->textInput() ?>

                <?= $form->field($model, 'active')->checkbox() ?>

                <?= $form->field($model, 'created_at')->textInput(['disabled' => true]) ?>

                <?= $form->field($model, 'updated_at')->textInput(['disabled' => true]) ?>

            </div>

            <div class="tab-pane" id="meta">

                <?= $form->field($model, 'meta_title')->textInput() ?>

                <?= $form->field($model, 'meta_description')->textarea(['rows' => 5]) ?>

                <?= $form->field($model, 'meta_image')->fileInput() ?>

            </div>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>


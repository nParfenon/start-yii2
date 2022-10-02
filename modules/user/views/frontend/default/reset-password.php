<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <?php $form = ActiveForm::begin([
        'id' => 'reset-password-form',
        'action' => '/try-reset-password',
    ]); ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

    <?= Yii::$app->session->getFlash('mailer_message') ?>

    <?= Html::submitButton('Reset password') ?>

    <?php ActiveForm::end(); ?>

</div>

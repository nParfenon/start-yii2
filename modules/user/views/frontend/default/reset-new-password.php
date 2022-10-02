<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'New password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <?php $form = ActiveForm::begin([
        'id' => 'reset-new-password-form',
        'action' => '/try-reset-new-password?token='.$_GET['token'],
    ]); ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'passwordRepeat')->passwordInput() ?>

    <?= Yii::$app->session->getFlash('reset_new_password_message') ?>

    <?= Html::submitButton('Register') ?>

    <?php ActiveForm::end(); ?>


</div>

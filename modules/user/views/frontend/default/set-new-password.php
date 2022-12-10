<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'New password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <?php $form = ActiveForm::begin([
        'action' => Url::to(['/user/default/try-set-new-password', 'token' => $_GET['token']]),
    ]); ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'passwordRepeat')->passwordInput() ?>

    <?= Yii::$app->session->getFlash('set_new_password_message') ?>

    <?= Html::submitButton('Register') ?>

    <?php ActiveForm::end(); ?>


</div>

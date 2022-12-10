<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <?php $form = ActiveForm::begin([
        'action' => '/user/default/try-login',
    ]); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <?= Yii::$app->session->getFlash('login_message') ?>

    <?= Html::submitButton('Login') ?>

    <?php ActiveForm::end(); ?>

</div>

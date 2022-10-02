<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\page\models\Page */

$this->title = 'Настройки';
$this->params['breadcrumbs'][] = ['label' => 'Основное'];
$this->params['breadcrumbs'][] = ['label' => 'Настройки'];

?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>



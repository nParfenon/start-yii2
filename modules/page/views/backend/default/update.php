<?php

/* @var $this yii\web\View */
/* @var $model app\modules\page\models\Page */

$this->title = 'Обновление страницы: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновление';
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>



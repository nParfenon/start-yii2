<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap4\Html;
use app\modules\settings\models\Settings;

AppAsset::register($this);

$setting = Settings::getValue(['name' => ['value'], 'description' => ['value']]);

$mainPage = [
    'title' => $setting['name']['value'],
    'description' => $setting['description']['value'],
];

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($mainPage['title']) ?></title>
    <meta name="description" content="<?= Html::encode($mainPage['description']) ?>">
    <?= $this->render('@app/views/partial/open_graph', ['mainPage' => $mainPage,]); ?>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">

    <?php $this->beginBody() ?>

        <?= $this->render('@app/views/partial/header'); ?>

        <?= $this->render('@app/views/partial/content', ['content' => $content]); ?>

        <?= $this->render('@app/views/partial/footer'); ?>

    <?php $this->endBody() ?>

</body>

</html>

<?php $this->endPage() ?>

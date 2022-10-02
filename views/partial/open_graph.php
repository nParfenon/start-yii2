<?php

Use yii\helpers\Html;

$title = $mainPage['title'];
$description = $mainPage['description'];

if (isset($this->params['page'])){

    $page = $this->params['page'];

    $title .= " - ".$page->meta_title;
    $description .= " - ".$page->meta_description;

}

?>

<!--open graph -->

<meta property="og:title" content="<?= Html::encode($title) ?>">
<meta property="og:description" content="<?= Html::encode($description) ?>">
<meta property="og:image" content="<?= isset($image) ? Html::encode($image) : '' ?>">

<meta property="twitter:title" content="<?= Html::encode($title) ?>">
<meta property="twitter:description" content="<?= Html::encode($description) ?>">
<meta property="twitter:image" content="<?= isset($image) ? Html::encode($image) : '' ?>">

<!--open graph -->
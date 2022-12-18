<?php

use yii\helpers\Html;
use app\modules\page\models\Page;

$title = $mainPage['title'];
$description = $mainPage['description'];

if ($page = Page::$page){

    if ($page->meta_title) $title .= " - ".$page->meta_title;

    if ($page->meta_description) $description .= " - ".$page->meta_description;

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
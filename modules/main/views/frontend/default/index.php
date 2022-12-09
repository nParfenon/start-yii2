<h1>Hi</h1>

<?php

if (!Yii::$app->user->isGuest){
    echo 'YES';
}

$prefix = '_it';
$id = 21;
$time = time() + 60 * 30;

$token = Yii::$app->security->generateRandomString() . $prefix . $id . $prefix . $time;

$exp = explode($prefix, $token);
var_dump(array_pop($exp));
var_dump(array_pop($exp));
var_dump($exp);
var_dump($token);
//var_dump(date('Y-m-d H:i:s',));
die();
?>

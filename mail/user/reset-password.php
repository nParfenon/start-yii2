<?php

use yii\helpers\Url;

$url = Url::base(true).'/reset-new-password?token='.$token

?>
<p>Ваша ссылка для восстановления пароля:</p><br>
<a href="<?= $url ?>"><?= $url ?></a>


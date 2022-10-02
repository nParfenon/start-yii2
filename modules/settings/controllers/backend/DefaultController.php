<?php

namespace app\modules\settings\controllers\backend;

use yii\web\Controller;
use app\modules\settings\models\Settings;

class DefaultController extends Controller
{

    public function actionUpdate()
    {
        $model = Settings::getSettings();

        if ($this->request->isPost) {

            $post = $this->request->post();

            foreach ($post as $item => $value){

                if (array_key_exists($item,$model)){

                    if (Settings::updateAll($value,"field = '$item'")){

                        $model[$item] =  array_merge($model[$item], $post[$item]);

                    }

                }

            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

}

<?php

namespace app\modules\main\controllers\frontend;

use app\controllers\FrontendController;

class DefaultController extends FrontendController
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $this->checkPage();

        return $this->render('index');
    }

    public function actionMaintenance()
    {
        return $this->render('maintenance');
    }

}
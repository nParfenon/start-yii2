<?php

namespace app\modules\main\controllers\frontend;

use app\controllers\FrontendController;
use brussens\maintenance\states\FileState;
use yii\web\NotFoundHttpException;

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
        if (!(new FileState())->isEnabled()) throw new NotFoundHttpException('Страница не найдена.');

        $this->layout = false;

        return $this->render('maintenance');
    }

}
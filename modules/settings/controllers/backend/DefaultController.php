<?php

namespace app\modules\settings\controllers\backend;

use Yii;
use ParseCsv\Csv;
use yii\web\Controller;
use app\modules\settings\Settings;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{

    public function actionIndex(): string
    {
        $csv = new Csv();
        $csv->delimiter = Settings::_DELIMITER;
        $csv->parseFile(Settings::_PATH . Settings::_FILE);

        return $this->render('index', [
            'data' => $csv->data,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionUpdate(): \yii\web\Response
    {
        if (!Yii::$app->request->isPost) throw new NotFoundHttpException();

        $post = $this->request->post('SettingForm');

        $csv = new Csv();
        $csv->delimiter = Settings::_DELIMITER;
        $csv->parseFile(Settings::_PATH . Settings::_FILE);
        $csv->data = array_replace_recursive($csv->data, $post);
        $csv->save();

        return $this->redirect(['index']);
    }

}

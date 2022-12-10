<?php

namespace app\modules\settings\controllers\backend;

use Yii;
use ParseCsv\Csv;
use yii\web\Controller;
use app\modules\settings\models\Settings;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{

    public function actionIndex()
    {
        $csv = new Csv();
        $csv->delimiter = Settings::_DELIMITER;
        $csv->parseFile(Settings::_PATH . 'setting.csv');

        return $this->render('index', [
            'data' => $csv->data,
        ]);
    }

    public function actionUpdate()
    {
        if (!Yii::$app->request->isPost) throw new NotFoundHttpException();

        $post = $this->request->post('SettingForm');

        $csv = new Csv();
        $csv->delimiter = Settings::_DELIMITER;
        $csv->parseFile(Settings::_PATH . 'setting.csv');
        $csv->data = array_replace_recursive($csv->data, $post);
        $csv->save();

        return $this->redirect(['index']);
    }

}

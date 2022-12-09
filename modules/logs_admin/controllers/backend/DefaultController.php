<?php

namespace app\modules\logs_admin\controllers\backend;

use app\modules\logs_admin\models\LogsAdmin;
use app\modules\logs_admin\models\LogsAdminSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for LogsAdmin model.
 */
class DefaultController extends Controller
{
    /**
     * @inheritDoc
     */
    /*public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }*/

    /**
     * Lists all LogsAdmin models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LogsAdminSearch();

        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LogsAdmin model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the LogsAdmin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return LogsAdmin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LogsAdmin::findOne(['id' => $id])) !== null) return $model;

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

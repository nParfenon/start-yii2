<?php

namespace app\modules\user\controllers\frontend;

use Yii;
use app\controllers\FrontendController;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\modules\user\models\User;
use app\modules\user\models\LoginForm;
use app\modules\user\models\RegisterForm;
use app\modules\user\models\ResetPasswordForm;
use app\modules\user\models\ResetNewPasswordForm;

class DefaultController extends FrontendController
{

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['login', 'register', 'reset-password', 'set-new-password', 'logout'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'register', 'reset-password', 'set-new-password'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionLogin(): string
    {
        $this->checkPage();

        $model = new LoginForm();

        return $this->render('login',[
            'model' => $model
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionRegister(): string
    {
        $this->checkPage();

        $model = new RegisterForm();

        return $this->render('register',[
            'model' => $model
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionResetPassword(): string
    {
        $this->checkPage();

        $model = new ResetPasswordForm();

        return $this->render('reset-password',[
            'model' => $model
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionSetNewPassword($token): string
    {
        $this->checkPage();

        if (!$user = User::findByPasswordToken($token)) throw new NotFoundHttpException('???????????? ???? ?????????????????????????? ?????? ???? ?????????? ??????????????.');

        $model = new ResetNewPasswordForm();

        return $this->render('set-new-password',[
            'model' => $model
        ]);
    }

    public function actionLogout(): \yii\web\Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionTryLogin(): \yii\web\Response
    {
        if (!Yii::$app->request->isPost) throw new NotFoundHttpException();

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post())) {

            if ($login = $model->tryLogin()) return $this->goHome();

            $message = implode($model->firstErrors);

        }

        Yii::$app->session->setFlash('login_message', $message ?? '???????????? ??????????. ???????????????????? ??????????');

        return $this->redirect(['/login']);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionTryRegister(): \yii\web\Response
    {
        if (!Yii::$app->request->isPost) throw new NotFoundHttpException();

        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post())) {

            $user = $model->tryRegister();

            if ($user) {

                Yii::$app->getUser()->login($user);

                return $this->goHome();

            }

        }

        Yii::$app->session->setFlash('register_message', '???????????? ??????????????????????. ???????????????????? ??????????');

        return $this->redirect(['/register']);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionTryResetPassword(): \yii\web\Response
    {
        if (!Yii::$app->request->isPost) throw new NotFoundHttpException();

        $model = new ResetPasswordForm();

        if ($model->load(Yii::$app->request->post())) {

            $token = $model->setPasswordToken();

            if ($token) {

                $mailer = Yii::$app->mailer->compose('user/set-new-password', ['token' => $token]);
                $mailer->setFrom(Yii::$app->params['senderEmail']);
                $mailer->setTo($model->email);

                if ($mailer->send()) $message = '???????????? ?????? ???????????????????????????? ???????????? ???????????????????? ???? ???????? ??????????';

                else $message = '???? ???? ???????????? ?????????????????? ???????????? ?????? ???????????????????????????? ????????????. ???????????????????? ??????????.';

            }else {

                $message = implode($model->firstErrors);

            }

        }

        Yii::$app->session->setFlash('reset_password_message', $message ?? '????????????. ???????????????????? ??????????');

        return $this->redirect(['/reset-password']);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionTrySetNewPassword($token)
    {
        if (!Yii::$app->request->isPost) throw new NotFoundHttpException();

        $model = new ResetNewPasswordForm();

        if ($model->load(Yii::$app->request->post())) {

            $newPassword = $model->setNewPassword($token);

            if (!$newPassword) {

                Yii::$app->session->setFlash('set_new_password_message', implode($model->firstErrors));

                return $this->redirect(['/set-new-password', 'token' => $token]);

            }

        }
    }
}

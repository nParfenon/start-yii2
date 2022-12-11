<?php

namespace app\modules\user\controllers\frontend;

use Yii;
use app\controllers\FrontendController;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use app\modules\user\models\User;
use app\modules\user\models\LoginForm;
use app\modules\user\models\RegisterForm;
use app\modules\user\models\ResetPasswordForm;
use app\modules\user\models\ResetNewPasswordForm;

class DefaultController extends FrontendController
{

    public function behaviors()
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

    public function actionLogin()
    {
        $this->checkPage();

        $model = new LoginForm();

        return $this->render('login',[
            'model' => $model
        ]);
    }

    public function actionRegister()
    {
        $this->checkPage();

        $model = new RegisterForm();

        return $this->render('register',[
            'model' => $model
        ]);
    }

    public function actionResetPassword()
    {
        $this->checkPage();

        $model = new ResetPasswordForm();

        return $this->render('reset-password',[
            'model' => $model
        ]);
    }

    public function actionSetNewPassword($token)
    {
        $this->checkPage();

        if (!$user = User::findByPasswordToken($token)) throw new NotFoundHttpException('Ссылка не действительна или ее время истекло.');

        $model = new ResetNewPasswordForm();

        return $this->render('set-new-password',[
            'model' => $model
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionTryLogin()
    {
        if (!Yii::$app->request->isPost) throw new NotFoundHttpException();

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post())) {

            if($login = $model->tryLogin()) return $this->goHome();

            Yii::$app->session->setFlash('login_message', implode($model->firstErrors));

            return $this->redirect(['/login']);

        }

    }

    public function actionTryRegister()
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

    }

    public function actionTryResetPassword()
    {
        if (!Yii::$app->request->isPost) throw new NotFoundHttpException();

        $model = new ResetPasswordForm();

        if ($model->load(Yii::$app->request->post())) {

            $token = $model->setPasswordToken();

            if ($token) {

                $mailer = Yii::$app->mailer->compose('user/set-new-password', ['token' => $token]);
                $mailer->setFrom(Yii::$app->params['senderEmail']);
                $mailer->setTo($model->email);

                if ($mailer->send()) $message = 'Ссылка для восстановления пароля отправлена на Вашу почту';

                else $message = 'Мы не смогли отправить ссылку для восстановления пароля. Попробуйте позже.';

            }else {

                $message = implode($model->firstErrors);

            }

            Yii::$app->session->setFlash('reset_password_message', $message);

            return $this->redirect(['/reset-password']);
        }

    }

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

            return $this->redirect(['/login']);
        }

    }

}

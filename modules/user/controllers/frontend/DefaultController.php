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

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['login', 'register', 'reset-password', 'reset-new-password', 'logout'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'register', 'reset-password', 'reset-new-password'],
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

    public function actionResetNewPassword($token = false)
    {
        if (!$token || !User::findByPasswordResetToken($token)) throw new NotFoundHttpException();

        $model = new ResetNewPasswordForm();

        return $this->render('reset-new-password',[
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
        if (Yii::$app->request->isPost) {

            $model = new LoginForm();

            if ($model->load(Yii::$app->request->post())) {

                if($model->tryLogin()) return $this->goHome();

                Yii::$app->session->setFlash('error', implode($model->firstErrors));

                return $this->redirect('/login');

            }

        }

        throw new NotFoundHttpException(Yii::$app->exceptionMessage->call("404"));
    }

    public function actionTryRegister()
    {
        if (Yii::$app->request->isPost) {
  
            $model = new RegisterForm();

            if ($model->load(Yii::$app->request->post())) {

                $user = $model->tryRegister();

                if ($user) {

                    Yii::$app->getUser()->login($user);

                    return $this->goHome();

                }

            }

        }

        throw new NotFoundHttpException(Yii::$app->exceptionMessage->call("404"));
    }

    public function actionTryResetPassword()
    {
        if (Yii::$app->request->isPost) {

            $model = new ResetPasswordForm();

            if ($model->load(Yii::$app->request->post())) {

                $token = $model->tryToken();

                if ($token) {

                    $mailer = Yii::$app->mailer->compose('user/reset-password', ['token' => $token]);
                    $mailer->setFrom(Yii::$app->params['senderEmail']);
                    $mailer->setTo($model->email);

                    if ($mailer->send()) {

                        Yii::$app->session->setFlash('mailer_message', 'Ссылка для восстановления пароля отправлена на Вашу почту');

                    } else {

                        Yii::$app->session->setFlash('mailer_message', 'Мы не смогли отправить ссылку для восстановления пароля. Попробуйте позже.');

                    }

                }else {

                    Yii::$app->session->setFlash('mailer_message', implode($model->firstErrors));

                }

                return $this->redirect('/reset-password');

            }

        }

        throw new NotFoundHttpException(Yii::$app->exceptionMessage->call("404"));
    }

    public function actionTryResetNewPassword($token)
    {
        if (Yii::$app->request->isPost) {

            $model = new ResetNewPasswordForm();

            if ($model->load(Yii::$app->request->post())) {

                $newPassword = $model->tryNewPassword($token);

                if (!$newPassword) {
                    Yii::$app->session->setFlash('reset_new_password_message', implode($model->firstErrors));

                    return $this->redirect('/reset-new-password?token='.$token);
                }

                return $this->goHome();
            }

        }

        throw new NotFoundHttpException(Yii::$app->exceptionMessage->call("404"));
    }

}

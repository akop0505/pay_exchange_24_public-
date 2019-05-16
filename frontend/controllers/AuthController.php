<?php

namespace frontend\controllers;

use common\models\Currencies;
use common\models\Reserves;
use common\services\CurrenciesService;
use common\services\StatisticService;
use frontend\components\Controller;
use frontend\models\Directions;
use frontend\models\Feedback;
use frontend\models\Bids;
use frontend\models\forms\ResetPasswordForm;
use frontend\models\forms\RestorePasswordForm;
use frontend\models\forms\SigninForm;
use frontend\models\SignupForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;


class AuthController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['signin'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'change-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['restore'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['reset-password'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }



    public function actionSignup()
    {
        $model = new \frontend\models\forms\SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->signup();
            $model->sendEmail();

            return $this->redirect(['cabinet/index']);
        }

        return $this->render('signup', compact('model'));
    }

    public function actionSignin()
    {
        $model = new SigninForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['cabinet/index']);
        }

        return $this->render('signin', compact('model'));
    }

    public function actionRestore()
    {
        $model = new RestorePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->sendEmail();
            Yii::$app->session->setFlash('message', 'Письмо с сылкой для востановления отправлено Вам на почту.');
            return $this->redirect(['signin']);
        }

        return $this->render('restore', compact('model'));
    }

    public function actionResetPassword($token)
    {
        $model = new ResetPasswordForm($token);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->resetPassword();
            return $this->redirect(['signin']);
        }

        return $this->render('reset-password', compact('model'));
    }

    /*public function actionChangePassword($token)
    {
        $model = new ResetPasswordForm($token);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->resetPassword();
            return $this->redirect(['signin']);
        }

        return $this->render('reset-password', compact('model'));
    }*/

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->session->set('__id', '');
        Yii::$app->session->set('user_id', '');
        Yii::$app->user->logout();

        return $this->goHome();
    }
}

<?php

namespace frontend\controllers;

use common\models\Referrals;
use common\models\Request;
use frontend\components\Controller;
use frontend\models\forms\ChangePasswordForm;
use frontend\models\forms\ReferralWithdrawForm;
use frontend\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;


class CabinetController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    $this->redirect(['auth/signin']);
                }
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {

            if (in_array($action->id, ['scroll'])) {
                $this->enableCsrfValidation = false;
            }

            return true;
        }

        return false;
    }

    public function actionWithdraw()
    {
        /** @var ReferralWithdrawForm $model */
        /** @var Referrals $referral */

        $referral = Yii::$app->user->getIdentity()->referral;
        $model = new ReferralWithdrawForm($referral);

        $success = false;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->makeWithdraw();

            $success = true;
        }

        return $this->asJson(['success' => $success, 'form' => $this->renderPartial('_withdraw_form', ['model' => $model])]);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $user = User::findOne(['id' => Yii::$app->user->id]);


        $dataProvider = new ActiveDataProvider([
            'query' => Request::find()->where(['email' => $user->email])->orderBy(['id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        if (Yii::$app->request->isAjax) {
            return $this->renderPartial('_items', ['dataProvider' => $dataProvider]);
        }


        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->session->setFlash('message', 'Пароль успешно изменен.');
            $model->changePassword();
            return $this->redirect(['index']);
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
}

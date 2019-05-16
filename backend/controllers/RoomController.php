<?php
namespace backend\controllers;

use backend\components\Controller;
use backend\models\referrals\ReferralFilter;
use common\models\enum\Role;
use common\models\Referrals;
use common\models\User;
use yii\web\NotFoundHttpException;

class RoomController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'][] = [
            'actions' => ['index'],
            'allow' => true,
            'roles' => [Role::ADMIN, Role::OPERATOR],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        if(!\Yii::$app->user->can(Role::ADMIN)){
            $selfReferral = Referrals::findOne(['user_id'=>\Yii::$app->user->id]);
            return $this->redirect(['monitor','id'=>$selfReferral->id]);
        }
        $filter = new ReferralFilter();

        return $this->render('index-filter',['filter' => $filter]);
    }

    public function actionMonitor($id)
    {
        $model = $this->findModel($id);

        if(!\Yii::$app->user->can(Role::ADMIN) && $model->user_id !== \Yii::$app->user->id){
            $referral = \Yii::$app->user->getIdentity()->referral;
            return $this->redirect(['monitor','id'=>$referral->id]);
        }

        $user = User::findOne($model->user_id);

        $filter = new ReferralFilter();
        $filter->id = $id;

        return $this->render('index', [
            'model' => $model,
            'filter' => $filter,
            'user' => $user
        ]);
    }

    /**
     * @param $id
     * @return Referrals
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $model = Referrals::findOne(['id' => $id]);

        if (!$model) {
            throw new NotFoundHttpException();
        }

        return $model;
    }
}
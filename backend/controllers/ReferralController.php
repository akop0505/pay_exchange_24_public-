<?php
namespace backend\controllers;


use backend\components\Controller;
use backend\models\referrals\ReferralCorrectForm;
use backend\models\referrals\ReferralFilter;
use backend\models\referrals\ReferralStat;
use backend\models\referrals\ReferralWithdrawForm;
use common\models\enum\Role;
use common\models\Referrals;
use common\models\ReferralsWithdraws;
use yii\web\NotFoundHttpException;

class ReferralController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'][] = [
            'actions' => ['index-monitor', 'index'],
            'allow' => true,
            'roles' => [Role::MONITOR],
        ];

        $behaviors['verbs']['actions']['delete-withdraw'] = ['POST'];

        return $behaviors;
    }

    public function actionIndex()
    {
        if (\Yii::$app->user->can(Role::OPERATOR)) {
            return $this->redirect(['index-monitor']);
        } else {
            return $this->redirect(['index-admin']);
        }
    }

    public function actionIndexAdmin()
    {
        $filter = new ReferralFilter();

        return $this->render('index-filter', compact('filter'));
    }

    public function actionMonitor($id)
    {
        $model = $this->findModel($id);

        $filter = new ReferralFilter();
        $filter->id = $id;

        return $this->render('index', compact('model', 'filter'));
    }

    public function actionIndexMonitor()
    {
        $model = \Yii::$app->user->getIdentity()->referral;

        if (!$model) {
            throw new NotFoundHttpException();
        }

        return $this->render('index_monitor', compact('model'));
    }

    public function actionAddWithdraw($id)
    {
        $model = $this->findModel($id);

        $form = new ReferralWithdrawForm($model);

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            $form->makeWithdraw();

            return $this->asJson(['success' => true]);
        }

        return $this->asJson(['success' => false, 'errors' => $form->errors]);
    }

    public function actionDeleteWithdraw($id, $referralId)
    {
        $model = ReferralsWithdraws::findOne(['id' => $id]);

        if ($model) {
            $model->delete();
        }

        return $this->redirect(['monitor', 'id' => $referralId]);
    }

    public function actionCorrect($id)
    {
        $model = $this->findModel($id);

        $form = new ReferralCorrectForm($model);

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            $form->makeCorrect();

            return $this->asJson(['success' => true]);
        }

        return $this->asJson(['success' => false, 'errors' => $form->errors]);
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

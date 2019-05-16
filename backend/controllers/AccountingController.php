<?php
namespace backend\controllers;


use backend\components\Controller;
use backend\models\AccountingFilter;
use backend\models\AddIncomeForm;
use Coinbase\Wallet\Exception\NotFoundException;
use common\models\Income;
use common\models\Request;
use common\models\Wallets;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class AccountingController extends Controller
{
    public function actionIndex()
    {
        $filter = new AccountingFilter();

        $dataProvider = new ActiveDataProvider([
            'query' => $filter->getQuery(),
            'pagination' => [
                //'pageSize' => 100,
                'pageSize' => 20,
            ],
            'sort' => false
        ]);

        $wallets = Wallets::find()->andWhere(['archived' => false])->orderBy('type, direction')->all();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'wallets' => $wallets,
            'filter' => $filter,
        ]);
    }

    public function actionAddIncome()
    {
        $form = new AddIncomeForm();

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            $form->addIncome();

            return $this->asJson(['success' => true]);
        }

        return $this->asJson(['success' => false, 'errors' => $form->errors]);
    }

    public function actionDeleteIncome($id)
    {
        $income = Income::findOne(['id' => $id]);

        if (!$income || !$income->request) {
            throw new NotFoundHttpException();
        }

        $request = $income->request;

        if ($request->incomeWallet && $request->sum_push) {
            $request->incomeWallet->dec($request->sum_push);
        }

        if ($request->outcomeWallet && $request->sum_pull) {
            $request->outcomeWallet->inc($request->sum_pull);
        }

        $request->delete();
        $income->delete();

        return $this->asJson(['success' => true]);
    }
}

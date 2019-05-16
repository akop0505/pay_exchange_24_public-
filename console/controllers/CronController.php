<?php

namespace console\controllers;

use backend\helpers\BidHelper;
use backend\modules\bestchange\services\Autobalancer;
use common\models\enum\RequestStatus;
use common\models\Request;
use common\models\Settings;
use common\models\Wallets;
use common\services\AccountingService;
use yii\console\Controller;
use yii\db\Expression;

class CronController extends Controller
{
    public function actionIndex()
    {

    }

    public function actionCancelBids()
    {
        $models = Request::find()
            ->andWhere(['done' => RequestStatus::DRAFT])
            ->andWhere(new Expression("
                UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(created_at) > 900
            "))->all();

        foreach ($models as $model) {
            AccountingService::create()->declineNewRequest($model);
        }
    }

    public function actionNullWallets()
    {
        $date = new \DateTime('now', new \DateTimeZone('Asia/Novosibirsk'));
        $h = (int) $date->format('H');
        if ($h >= 0 && $h <= 1) {
            Wallets::updateAll(['trans_sends' => 0, 'trans_receive' => 0]);
        }
    }

    public function actionEthBids()
    {
        BidHelper::updateCryptCurrencyBidsStatus();
    }

}
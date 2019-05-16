<?php

use backend\models\AccountingFilter;
use common\models\enum\RequestStatus;
use common\models\Income;
use common\models\Wallets;
use common\services\AccountingService;
use common\services\CryptRateService;
use common\services\WalletsService;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model Income */
/* @var $wallets Wallets[] */
/* @var $filter AccountingFilter */

$this->title = 'Accounting';
$this->params['breadcrumbs'][] = $this->title;
$this->params['bodyClass'] = 'fixed-header-page';

$walletsByCurrency = ArrayHelper::map($wallets, 'id', function ($m) {return $m;}, 'direction');

$flow = ArrayHelper::map(AccountingService::create()->getWalletsMoneyFlow($filter), 'id', 'flow');
?>

<div class="accounting-index">

    <br><br>

    <div class="clearfix">


        <div class="accounting-filter pull-left">

            <?php $form = ActiveForm::begin([
                'enableClientValidation' => false,
                'options' => ['class' => 'form-inline']
            ])?>

            <div class="date-filter">

                <?= $form->field($filter, 'dateFrom')->widget(DatePicker::className(), [
                    'dateFormat' => 'dd.MM.yyyy',
                    'options' => ['class' => 'form-control']
                ])->label('C')->error(false)?>

                <?= $form->field($filter, 'dateTo')->widget(DatePicker::className(), [
                    'dateFormat' => 'dd.MM.yyyy',
                    'options' => ['class' => 'form-control'],
                ])->label('По')->error(false)?>

                <button type="submit" class=" btn btn-primary">Показать</button>
            </div>



            <?php ActiveForm::end()?>

        </div>

        <?= Html::button('Добавить', ['class' => 'btn btn-success pull-right js-income-form-caller'])?>
    </div>

    <br><br>

    <div class="accounting-grid"
         data-app-controller="accounting_grid"
         data-app-options='<?= Json::encode([
             'getRowUrl' => Url::toRoute(['get-grid-row']),
             'getNewRowsUrl' => Url::toRoute(['get-grid-new-rows']),
         ])?>'
    >

        <table class="table table-bordered table-hover table-condensed">
            <thead></thead>
            <tbody>

                <tr>
                    <td><strong>Суммарно:</strong></td>

                    <?php foreach ($walletsByCurrency as $currency => $curWallets) {?>
                        <td class="wallet-summary" colspan="<?= count($curWallets)?>">
                            <?php if ($currency == 'BTC' || $currency == 'ETH' || $currency == 'BCH') {?>
                                <?= WalletsService::create()->getBalance($curWallets, false)?> <?= $currency?> <br>
                            <?php } ?>

                            <?= round(WalletsService::create()->getBalance($curWallets), 2)?> RUB
                        </td>
                    <?php } ?>

                    <td rowspan="2" class="wallet-summary">
                        <strong>Прибыль:</strong> <?= round(AccountingService::create()->getTotalProfit($filter), 2)?>
                    </td>
                </tr>

                <tr>
                    <td>Баланс: <strong><?= round(WalletsService::create()->getBalance($wallets), 2)?></strong></td>

                    <?php foreach ($wallets as $wallet) { ?>
                        <td>
                            <div class="wallet-info"><strong><?= $wallet->direction?></strong></div>
                            <div class="wallet-info">**<?= substr($wallet->requisite, strlen($wallet->requisite) - 4)?></div>
                            <div class="wallet-info">
                                <?php if ($wallet->isCryptWallet()) {?>
                                    Рез.: <br>
                                    <?= $wallet->balance ?> <?= $wallet->direction ?> <br>
                                    <?= round($wallet->balance * CryptRateService::create()->get($wallet->direction), 2) ?> RUB
                                <?php } else {?>
                                    Рез.: <?= $wallet->balance ?>
                                <?php } ?>
                            </div>
                            Об.: <?= isset($flow[$wallet->id]) ? $flow[$wallet->id] : ''?>
                        </td>
                    <?php } ?>
                </tr>


                <?php foreach ($dataProvider->getModels() as $model) {
                    $request = $model->request; ?>

                    <tr data-id="<?= $model->id?>">

                        <td>
                            <?php if ($request->done == RequestStatus::INTERNAL_OPERATIONS) {?>
                                <span class="accounting-grid__comment"><?= $request->email ?></span>
                                <?= Html::button('Удалить', [
                                    'class' => 'btn btn-danger btn-xs accounting-grid__remove-btn js-remove-op-btn',
                                    'data-id' => $model->id,
                                    'data-url' => Url::toRoute(['delete-income', 'id' => $model->id])
                                ])?>
                            <?php } else { ?>
                                <span class="accounting-grid__id"><?= '# '.$request->id ?></span>
                            <?php } ?>
                        </td>

                        <?php foreach ($wallets as $wallet) { ?>
                            <td>
                                <?php if ($wallet->id == $request->currency_from_wallet && $request->sum_push > 0) {

                                    echo $request->sum_push;

                                } else if ($wallet->id == $request->currency_to_wallet) {

                                    if ($request->outcomeWallet->isCryptWallet()) {
                                        echo '-' . (abs($request->sum_pull) + $model->comission);
                                    } else {
                                        echo '-' . round(abs($request->sum_pull) + $model->comission, 2);
                                    }

                                } ?>
                            </td>
                        <?php } ?>

                        <td><?= $request->done == RequestStatus::INTERNAL_OPERATIONS ? 0 : $model->amount?></td>

                    </tr>

                <?php } ?>

            </tbody>
        </table>

        <?= LinkPager::widget([
            'pagination' => $dataProvider->pagination,
        ]) ?>

    </div>


</div>

<?= $this->render('_form_add')?>
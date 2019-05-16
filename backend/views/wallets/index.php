<?php

use common\models\Settings;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Json;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProviderActive yii\data\ActiveDataProvider */

$this->title = 'Wallets';
$this->params['breadcrumbs'][] = $this->title;


$rotationEnabled = Settings::get()->wallets_rotation;
$alerts = [];
if ($rotationEnabled) {
    $models = $dataProviderActive->getModels();


    $res = (new Query())
        ->select(["
            direction,
            count(id) cnt_all,
            SUM(IF(trans_receive >= trans_available, 1, 0)) cnt_bad
        "])
        ->from("wallets")
        ->andWhere(['in_rotation' => true])
        ->groupBy("direction")
        ->having(new Expression("cnt_bad >= CEIL(cnt_all / 2)"))
        ->all();

    foreach ($res as $item) {
        $alerts[] = "Осталась половина {$item['direction']} счетов";
    }
}

?>

<?php foreach ($alerts as $alert) { ?>
    <script>alert('<?= $alert?>');</script>
<?php } ?>


<div class="wallets-index">

    <p>
        <?= Html::a('Create Wallet', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="clearfix">

        <div class="btn-group pull-left" data-toggle="buttons" data-app-controller="rotation_config"
             data-enable-url="<?= Url::toRoute(['wallets/settings-rotation-toggle']) ?>">
            <label class="btn btn-primary <?= $rotationEnabled ? 'active' : '' ?>">
                <input type="radio" name="enable" value="1"
                       class="js-enable-btn" <?= $rotationEnabled ? 'checked="checked"' : '' ?>> Ротации вкл.
            </label>
            <label class="btn btn-primary <?= !$rotationEnabled ? 'active' : '' ?>">
                <input type="radio" name="enable" value="0"
                       class="js-enable-btn" <?= !$rotationEnabled ? 'checked="checked"' : '' ?>> Ротации выкл.
            </label>
        </div>

    </div>

    <br>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#active" data-toggle="tab">Активные</a></li>
        <li><a href="#archive" data-toggle="tab">Архив</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">

        <div class="tab-pane active" id="active">

            <div class="panel panel-default panel-tabs">
                <div class="panel-body" data-app-controller="wallets_list">
                    <?= GridView::widget([
                        'dataProvider' => $dataProviderActive,
                        'layout' => '{items}',
                        'columns' => [
                            'direction',
                            [
                                'attribute' => 'balance',
                                'format' => 'raw',
                                'value'=> function($model){
                                    return rtrim(rtrim($model->balance,'0'),'.');
                                }
                            ],
                            'requisite',
                            'requisite_full_name',
                            [
                                'label' => 'Транзакции',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Yii::$app->controller->view->render('_edit_widget', ['model' => $model]);
                                }
                            ],
                            [
                                'attribute' => 'in_rotation',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Html::activeCheckbox($model, 'in_rotation', [
                                        'label' => false,
                                        'class' => 'js-rotation-check',
                                        'data-url' => Url::toRoute(['wallets/rotation-toggle', 'id' => $model->id])
                                    ]);
                                }
                            ],
                            'active:boolean',

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update}&nbsp;&nbsp;{archive}',
                                'buttons' => [
                                    'archive' => function ($url, $model, $key) {
                                        return Html::a('<span class="glyphicon glyphicon-inbox"></span>', '#', [
                                            //'data-pjax' => '0',
                                            //'data-method' => 'post',
                                            'title' => 'В архив',
                                            'class' => 'js-to-archive',
                                            'data-id' => $model->id,
                                            'data-is-active' => $model->active,
                                            'data-url' => Url::toRoute(['get-archive-form', 'id' => $model->id]),
                                            //'data-confirm' => 'В архив?',
                                        ]);
                                    },

                                ]
                            ],
                        ],
                    ]); ?>

                </div>
            </div>

        </div>

        <div class="tab-pane" id="archive">

            <div class="panel panel-default panel-tabs">
                <div class="panel-body">

                    <?= GridView::widget([
                        'dataProvider' => $dataProviderArchived,
                        'layout' => '{items}',
                        'columns' => [
                            'direction',
                            [
                                'attribute' => 'balance',
                                'format' => 'raw',
                                'value'=> function($model){
                                    return rtrim(rtrim($model->balance,'0'),'.');
                                }
                            ],
                            'requisite',

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{active}&nbsp;&nbsp;{delete}',
                                'buttons' => [
                                    'active' => function ($url, $model, $key) {
                                        return Html::a('<span class="glyphicon glyphicon-share"></span>', $url, [
                                            'data-pjax' => '0',
                                            'data-method' => 'post',
                                            'title' => 'Активировать',
                                            'data-confirm' => 'Активировать?',
                                        ]);
                                    },

                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<span class="glyphicon glyphicon-inbox"></span>', $url, [
                                            'data-pjax' => '0',
                                            'data-method' => 'post',
                                            'title' => 'Удалить',
                                            'data-confirm' => 'Вы уверены, что хотите удалить кошелек? Все данные будут утеряны.',
                                        ]);
                                    },

                                ]
                            ],
                        ],
                    ]); ?>

                </div>
            </div>

        </div>

    </div>

</div>


<div class="modal fade" data-app-controller="wallets_archive_form"
     data-app-options='<?= Json::encode(['caller' => '.js-to-archive']) ?>'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content js-body">

        </div>
    </div>
</div>

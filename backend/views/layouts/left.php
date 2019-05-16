<aside class="main-sidebar">

    <section class="sidebar">

        <?php

        use common\models\enum\Role;

        $auth = Yii::$app->authManager;
        
        echo dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [

                    ['label' => 'Заявки', 'icon' => 'circle', 'url' => ['/requests/index'], 'visible' => Yii::$app->user->can('admin')],

                    ['label' => 'Учет', 'icon' => 'circle', 'url' => ['/accounting/index'], 'visible' => Yii::$app->user->can('admin')],

                    ['label' => 'Направления', 'icon' => 'circle', 'url' => ['/directions/index'], 'visible' => Yii::$app->user->can(Role::OPERATOR)],

                    ['label' => 'Автобалансировка', 'icon' => 'circle', 'url' => ['/bestchange/autobalance/index'], 'visible' => Yii::$app->user->can(Role::OPERATOR)],

                    ['label' => 'Резервы', 'icon' => 'circle', 'url' => ['/reserves/index'], 'visible' => Yii::$app->user->can('admin')],

                    ['label' => 'Кошельки', 'icon' => 'circle', 'url' => ['/wallets/index'], 'visible' => Yii::$app->user->can('admin')],

                    /*['label' => 'Статистика', 'icon' => 'circle', 'url' => ['/stats/index'], 'visible' => Yii::$app->user->can('admin')],*/

                    ['label' => 'Sms', 'icon' => 'circle', 'url' => ['/sms/index'], 'visible' => Yii::$app->user->can('admin')],

                    ['label' => 'Реф. начисления', 'icon' => 'circle', 'url' => ['/referral/index'], 'visible' => Yii::$app->user->can('monitor')],

                    ['label' => 'Online/Ofline', 'icon' => 'circle', 'url' => ['/config/index'], 'visible' => Yii::$app->user->can('admin')],

                    ['label' => 'Пользователи', 'icon' => 'circle', 'url' => ['/user/index'], 'visible' => Yii::$app->user->can('admin')],

                    ['label' => 'Личный кабинет', 'icon' => 'circle', 'url' => ['/room/index'], 'visible' => Yii::$app->user->can(Role::OPERATOR)],

                    /*[
                        'label' => Yii::t('app', 'Test'),
                        'icon' => 'fa fa-bars',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Обрамляющие шаблоны', 'icon' => 'fa fa-circle', 'url' => ['/categories/index'], 'visible' => Yii::$app->user->can('admin')],
                            ['label' => 'Страницы (Шаги)', 'icon' => 'fa fa-circle', 'url' => ['/users/index'], 'visible' => Yii::$app->user->can('admin')],
                        ],
                    ],*/
                ],
            ]
        ) ?>

    </section>

</aside>

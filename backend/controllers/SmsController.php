<?php

namespace backend\controllers;

use Yii;
use backend\components\Controller;
use backend\models\Sms;
use backend\models\SmsSearch;
use common\services\StatDataService;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

class SmsController extends Controller
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
	                		'actions' => ['index'],
	                        'allow' => true,
	                        'roles' => ['admin'],
	                        ]
                    ]
                ]
        ];
    }


    public function actionIndex()
    {
    
        $searchModel  = new SmsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}

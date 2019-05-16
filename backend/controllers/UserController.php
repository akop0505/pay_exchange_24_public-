<?php

namespace backend\controllers;

use backend\components\Controller;
use common\models\User;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use Yii;
use yii\helpers\Json;

class UserController extends Controller
{

	public function behaviors()
    {
        return [
        	'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    $this->redirect(['/site/login']);
                }
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

	public function actionIndex()
	{
		if (Yii::$app->request->isAjax && Yii::$app->request->getIsPost()) {
			$user 	= Yii::$app->request->post('User');
			$key	= Yii::$app->request->post('editableKey');
			$i		= Yii::$app->request->post('editableIndex');
			if ($user && isset($user[$i]['comment']) && !empty($key)) {
				if (User::updateComment($key, $user[$i]['comment'])) {
					$out = Json::encode(['output'=>$user[$i]['comment'], 'message'=>'']);
					echo $out; 
				}
				return;
			}
			if ($user && isset($user[$i]['role']) && !empty($key)) {
				if (User::updateRole($key, $user[$i]['role'])) {
					$out = Json::encode(['output'=>$user[$i]['role'], 'message'=>'']);
					echo $out; 
				}
				return;
			}
		}
		$dataProvider = new ActiveDataProvider([
		    'query' => User::find(),
		    'sort' => [
            	'defaultOrder'=>[ 'username' => SORT_ASC ],
            ],
		]);
		return $this->render('index', ["dataProvider" => $dataProvider]);
	}

	public function actionCreate()
	{
		$model = new User(['scenario' => User::SCENARIO_ADD]);

		if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
			if($model->save()){
				Yii::$app
		            ->mailer
		            ->compose(
		                ['html' => 'passwordCreate-html', 'text' => 'passwordResetToken-text'],
		                ['user' => $model]
		            )
		            ->setFrom([Yii::$app->params['supportEmail'] => ' ' . Yii::$app->name])
		            ->setTo($model->email)
		            ->setSubject('Регистрация аккаунта - ' . Yii::$app->name)
		            ->send();
				$this->redirect(['user/create']);
			}
		}
		return $this->render('create',["model" => $model]);
	}

	public function actionDelete($id)
	{
		User::find()->where(['id' =>$id])->one()->delete();
		return $this->redirect(['index']);
	}

    public function actionUpdatePercent($id)
    {
        $model = User::findOne($id);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->asJson(['success' => true]);
        }
        return $this->asJson(['success' => false, 'errors' => $model->errors]);
    }
}

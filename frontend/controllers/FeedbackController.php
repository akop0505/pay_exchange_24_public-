<?php

namespace frontend\controllers;

use frontend\components\Controller;
use frontend\models\forms\FeedbackForm;
use himiklab\yii2\recaptcha\ReCaptcha;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Html;


class FeedbackController extends Controller
{
    /**
     * @inheritdoc
     */
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                ],
            ],
        ];
    }*/



    public function actionCreate()
    {
        $model = new FeedbackForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->createFeedback();

            return $this->asJson(['success' => true]);
        }

        $errors = [];
        foreach ($model->errors as $error) {
            foreach ($error as $item) {
                $errors[] = $item;
            }
        }

        return $this->asJson([
            'success' => false,
            'error' => join('<br>', $errors),
        ]);
    }
}

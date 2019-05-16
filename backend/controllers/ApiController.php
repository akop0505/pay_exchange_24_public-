<?php

namespace backend\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use backend\models\Sms;

/**
 * Description of ApiController
 *
 * @author iliya
 */
class ApiController extends Controller
{

    public $sms;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'sms' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionSms()
    {
        $content = file_get_contents('php://input');
        if ($content) {
            $data = json_decode($content);
            if (
                    $data !== null &&
                    $data->number &&
                    $data->body &&
                    $data->date
            ) {
                $sms = new Sms();
                $sms->number = $data->number;
                $sms->name = isset($sms->name) ? $data->name : '';
                $sms->body = $data->body;
                $sms->date = $data->date;
            } else {
                throw new HttpException(403);
            }
            if ($sms->save()) {
                echo 'ok';
            } else {
                echo 'error';
            }
            die();
        } else {
            throw new HttpException(403);
        }
    }

}

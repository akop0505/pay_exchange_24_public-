<?php

namespace backend\controllers;

use backend\models\wallets\ArchiveForm;
use common\models\Settings;
use Yii;
use common\models\Wallets;
use yii\data\ActiveDataProvider;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WalletsController implements the CRUD actions for Wallets model.
 */
class WalletsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs']['actions']['archive'] = ['POST'];
        $behaviors['verbs']['actions']['active'] = ['POST'];

        return $behaviors;
    }

    /**
     * Lists all Wallets models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProviderActive = new ActiveDataProvider([
            'query' => Wallets::find()
                ->andWhere(['archived' => false])
                ->orderBy(['type'=>SORT_ASC,'direction'=>SORT_ASC]),
            'pagination' => false,
        ]);

        $dataProviderArchived = new ActiveDataProvider([
            'query' => Wallets::find()
                ->andWhere(['archived' => true])
                ->orderBy(['type'=>SORT_ASC,'direction'=>SORT_ASC]),
            'pagination' => false,
        ]);

        return $this->render('index', compact('dataProviderActive', 'dataProviderArchived'));
    }

    /**
     * Creates a new Wallets model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Wallets();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Wallets model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionGetArchiveForm($id)
    {
        $model = $this->findModel($id);

        return $this->renderPartial('archive_form', compact('model'));
    }

    public function actionArchive($id)
    {
        $model = $this->findModel($id);

        if ($model->active) {

            $form = new ArchiveForm();
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {

                $wallet = Wallets::findOne(['id' => $form->newWalletId]);
                if ($wallet) {
                    $wallet->active = true;
                    $wallet->save(false);

                    $model->refresh();
                    $model->archived = true;
                    $model->save(false);
                }

            } else {
                return $this->asJson(['error' => 'Не выбран новый кошелек']);
            }

        } else {
            $model->archived = true;
            $model->save(false);
        }

        return $this->asJson(['success' => true]);
    }

    public function actionActive($id)
    {
        $model = $this->findModel($id);

        $model->archived = false;
        $model->save(false);

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Wallets model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->archived) {
            $model->delete();
        }

        return $this->redirect(['index']);
    }

    public function actionSaveTransactions($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->save(false, ['trans_available']);
        }

        return $this->asJson([true]);
    }

    public function actionRotationToggle($id)
    {
        $model = $this->findModel($id);

        $model->in_rotation = $model->in_rotation ? false : true;

        $model->save(false);
    }

    public function actionSettingsRotationToggle($enable)
    {
        $model = Settings::get();
        $model->wallets_rotation = intval((bool) $enable);
        $model->save(false);
    }

    /**
     * Finds the Wallets model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Wallets the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $select = ["*","TRIM(TRAILING '.' from TRIM(TRAILING '0' from balance)) as  `balance`"];
        if (($model = Wallets::find()->select($select)->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

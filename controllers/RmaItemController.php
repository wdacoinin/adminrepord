<?php

namespace app\controllers;

use app\models\RmaItemT;
use app\models\RmaItem;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RmaItemController implements the CRUD actions for RmaItemT model.
 */
class RmaItemController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all RmaItemT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new RmaItem();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RmaItemT model.
     * @param int $rma_item Rma Item
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($rma_item)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($rma_item),
        ]);
    }

    /**
     * Creates a new RmaItemT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new RmaItemT();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $check = RmaItemT::find()->where(['nama' => $model->divisi])->count();
            if($check > 0){
                Yii::$app->session->setFlash('warning', 'Nama sudah ada, data tidak di simpan!');
            }else{

                if($model->save()) {
                    Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                } else {
                    Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                }
            }
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RmaItemT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $rma_item Rma Item
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($rma_item)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($rma_item);

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            if($model->save()) {
                Yii::$app->session->setFlash('success', 'Data berhasil update!');
            } else {
                Yii::$app->session->setFlash('error', 'Data tidak berhasil di update');
            }
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RmaItemT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $rma_item Rma Item
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($rma_item)
    {
        $this->findModel($rma_item)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RmaItemT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $rma_item Rma Item
     * @return RmaItemT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($rma_item)
    {
        if (($model = RmaItemT::findOne(['rma_item' => $rma_item])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

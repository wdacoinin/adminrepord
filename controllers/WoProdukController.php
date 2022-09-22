<?php

namespace app\controllers;

use app\models\WoProdukT;
use app\models\WoProduk;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WoProdukController implements the CRUD actions for WoProdukT model.
 */
class WoProdukController extends Controller
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
     * Lists all WoProdukT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new WoProduk();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WoProdukT model.
     * @param int $wo_produk Wo Produk
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($wo_produk)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($wo_produk),
        ]);
    }

    /**
     * Creates a new WoProdukT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new WoProdukT();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $check = WoProdukT::find()->where(['nama' => $model->divisi])->count();
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
     * Updates an existing WoProdukT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $wo_produk Wo Produk
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($wo_produk)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($wo_produk);

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
     * Deletes an existing WoProdukT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $wo_produk Wo Produk
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($wo_produk)
    {
        $this->findModel($wo_produk)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WoProdukT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $wo_produk Wo Produk
     * @return WoProdukT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($wo_produk)
    {
        if (($model = WoProdukT::findOne(['wo_produk' => $wo_produk])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

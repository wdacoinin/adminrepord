<?php

namespace app\controllers;

use app\models\PenjualanProdukTtT;
use app\models\PenjualanProdukTt;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PenjualanProdukTtController implements the CRUD actions for PenjualanProdukTtT model.
 */
class PenjualanProdukTtController extends Controller
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
     * Lists all PenjualanProdukTtT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new PenjualanProdukTt();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PenjualanProdukTtT model.
     * @param int $penjualan_produk_tt Penjualan Produk Tt
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($penjualan_produk_tt)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($penjualan_produk_tt),
        ]);
    }

    /**
     * Creates a new PenjualanProdukTtT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new PenjualanProdukTtT();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $check = PenjualanProdukTtT::find()->where(['nama' => $model->divisi])->count();
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
     * Updates an existing PenjualanProdukTtT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $penjualan_produk_tt Penjualan Produk Tt
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($penjualan_produk_tt)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($penjualan_produk_tt);

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
     * Deletes an existing PenjualanProdukTtT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $penjualan_produk_tt Penjualan Produk Tt
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($penjualan_produk_tt)
    {
        $this->findModel($penjualan_produk_tt)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PenjualanProdukTtT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $penjualan_produk_tt Penjualan Produk Tt
     * @return PenjualanProdukTtT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($penjualan_produk_tt)
    {
        if (($model = PenjualanProdukTtT::findOne(['penjualan_produk_tt' => $penjualan_produk_tt])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

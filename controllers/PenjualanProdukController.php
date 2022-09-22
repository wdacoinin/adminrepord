<?php

namespace app\controllers;

use app\models\PenjualanProdukT;
use app\models\PenjualanProduk;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PenjualanProdukController implements the CRUD actions for PenjualanProdukT model.
 */
class PenjualanProdukController extends Controller
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
     * Lists all PenjualanProdukT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new PenjualanProduk();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PenjualanProdukT model.
     * @param int $penjualan_produk Penjualan Produk
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($penjualan_produk)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($penjualan_produk),
        ]);
    }

    /**
     * Creates a new PenjualanProdukT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new PenjualanProdukT();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'penjualan_produk' => $model->penjualan_produk]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PenjualanProdukT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $penjualan_produk Penjualan Produk
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($penjualan_produk)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($penjualan_produk);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'penjualan_produk' => $model->penjualan_produk]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PenjualanProdukT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $penjualan_produk Penjualan Produk
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($penjualan_produk)
    {
        $this->findModel($penjualan_produk)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PenjualanProdukT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $penjualan_produk Penjualan Produk
     * @return PenjualanProdukT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($penjualan_produk)
    {
        if (($model = PenjualanProdukT::findOne(['penjualan_produk' => $penjualan_produk])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

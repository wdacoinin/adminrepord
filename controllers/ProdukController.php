<?php

namespace app\controllers;

use Yii;
use yii\widgets\ActiveForm;
use app\models\ProdukT;
use app\models\Produk;
use app\models\Produkvs;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProdukController implements the CRUD actions for ProdukT model.
 */
class ProdukController extends Controller
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
     * Lists all ProdukT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Produkvs();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProdukT model.
     * @param int $produk Produk
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($produk)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($produk),
        ]);
    }

    /**
     * Creates a new ProdukT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new ProdukT();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $check = ProdukT::find()->where(['nama' => $model->nama])->count();
            if($check > 0){
                Yii::$app->session->setFlash('warning', 'Nama produk sudah ada, berikan pembeda, data tidak di simpan!');
            }else{
                
                $model->kategori = (int) $model->kategori;
                $model->merek = (int) $model->merek;
                if($model->save()) {
                    Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                } else {
                    Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                }
            }
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProdukT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $produk Produk
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($produk)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($produk);

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
     * Deletes an existing ProdukT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $produk Produk
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($produk)
    {
        $this->findModel($produk)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProdukT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $produk Produk
     * @return ProdukT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($produk)
    {
        if (($model = ProdukT::findOne(['produk' => $produk])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

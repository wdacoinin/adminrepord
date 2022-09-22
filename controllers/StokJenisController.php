<?php

namespace app\controllers;

use Yii;
use yii\widgets\ActiveForm;
use app\models\StokJenisT;
use app\models\StokJenis;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StokJenisController implements the CRUD actions for StokJenisT model.
 */
class StokJenisController extends Controller
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
     * Lists all StokJenisT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new StokJenis();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StokJenisT model.
     * @param int $stok_jenis Stok Jenis
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($stok_jenis)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($stok_jenis),
        ]);
    }

    /**
     * Creates a new StokJenisT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new StokJenisT();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $check = StokJenisT::find()->where(['stok_jenis_nama' => $model->stok_jenis_nama])->count();
            if($check > 0){
                Yii::$app->session->setFlash('warning', 'Nama jenis stok sudah ada, data tidak di simpan!');
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
     * Updates an existing StokJenisT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $stok_jenis Stok Jenis
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($stok_jenis)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($stok_jenis);
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
     * Deletes an existing StokJenisT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $stok_jenis Stok Jenis
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($stok_jenis)
    {
        $this->findModel($stok_jenis)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StokJenisT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $stok_jenis Stok Jenis
     * @return StokJenisT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($stok_jenis)
    {
        if (($model = StokJenisT::findOne(['stok_jenis' => $stok_jenis])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

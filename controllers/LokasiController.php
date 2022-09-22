<?php

namespace app\controllers;

use Yii;
use yii\widgets\ActiveForm;
use app\models\LokasiT;
use app\models\Lokasi;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LokasiController implements the CRUD actions for LokasiT model.
 */
class LokasiController extends Controller
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
     * Lists all LokasiT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Lokasi();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LokasiT model.
     * @param int $lokasi Lokasi
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($lokasi)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($lokasi),
        ]);
    }

    /**
     * Creates a new LokasiT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new LokasiT();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $check = LokasiT::find()->where(['nama' => $model->nama])->count();
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
     * Updates an existing LokasiT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $lokasi Lokasi
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($lokasi)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($lokasi);

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
     * Deletes an existing LokasiT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $lokasi Lokasi
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($lokasi)
    {
        $this->findModel($lokasi)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LokasiT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $lokasi Lokasi
     * @return LokasiT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($lokasi)
    {
        if (($model = LokasiT::findOne(['lokasi' => $lokasi])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

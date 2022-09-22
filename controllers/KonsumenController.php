<?php

namespace app\controllers;

use yii;
use app\models\KonsumenT;
use app\models\Konsumen;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * KonsumenController implements the CRUD actions for KonsumenT model.
 */
class KonsumenController extends Controller
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
     * Lists all KonsumenT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Konsumen();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single KonsumenT model.
     * @param int $konsumen Konsumen
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($konsumen)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($konsumen),
        ]);
    }

    /**
     * Creates a new KonsumenT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new KonsumenT();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $check = KonsumenT::find()->where(['konsumen_nama' => $model->konsumen_nama])->count();
            if($check > 0){
                Yii::$app->session->setFlash('warning', 'Nama konsumen sudah ada, beri pembeda, data tidak di simpan!');
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
     * Updates an existing KonsumenT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $konsumen Konsumen
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($konsumen)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($konsumen);
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
     * Deletes an existing KonsumenT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $konsumen Konsumen
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($konsumen)
    {
        $this->findModel($konsumen)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the KonsumenT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $konsumen Konsumen
     * @return KonsumenT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($konsumen)
    {
        if (($model = KonsumenT::findOne($konsumen)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    /*public function beforeAction($action){

        if (Yii::$app->user->isGuest){
            return $this->redirect(['site/login'])->send();  // login path
        }
    }*/
}

<?php

namespace app\controllers;

use yii;
use app\models\DivisiT;
use app\models\Divisi;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * DivisiController implements the CRUD actions for DivisiT model.
 */
class DivisiController extends Controller
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
     * Lists all DivisiT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Divisi();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DivisiT model.
     * @param int $divisi Divisi
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($divisi)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($divisi),
        ]);
    }

    /**
     * Creates a new DivisiT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new DivisiT();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $checkdivisi = DivisiT::find()->where(['nama' => $model->divisi])->count();
            if($checkdivisi > 0){
                Yii::$app->session->setFlash('warning', 'Nama divisi sudah ada, data tidak di simpan!');
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
     * Updates an existing DivisiT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $divisi Divisi
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($divisi)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($divisi);
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
     * Deletes an existing DivisiT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $divisi Divisi
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($divisi)
    {
        $this->findModel($divisi)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DivisiT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $divisi Divisi
     * @return DivisiT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($divisi)
    {
        if (($model = DivisiT::findOne($divisi)) !== null) {
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

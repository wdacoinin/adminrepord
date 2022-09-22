<?php

namespace app\controllers;

use yii;
use app\models\AkunT;
use app\models\Akun;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * AkunController implements the CRUD actions for AkunT model.
 */
class AkunController extends Controller
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
     * Lists all AkunT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Akun();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AkunT model.
     * @param int $akun Akun
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($akun)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($akun),
        ]);
    }

    /**
     * Creates a new AkunT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new AkunT();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $check = AkunT::find()->where(['akun_ref' => $model->akun_ref])->count();
            if($check > 0){
                Yii::$app->session->setFlash('warning', 'No.rek sudah ada, data tidak di simpan!');
            }else{
                if($model->save()) {
                    Yii::$app->session->setFlash('success', 'Data berhasil di simpan.');
                } else {
                    Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan!');
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
     * Updates an existing AkunT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $akun Akun
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($akun)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($akun);


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
     * Deletes an existing AkunT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $akun Akun
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($akun)
    {
        $this->findModel($akun)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AkunT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $akun Akun
     * @return AkunT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($akun)
    {
        if (($model = AkunT::findOne($akun)) !== null) {
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

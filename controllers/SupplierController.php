<?php

namespace app\controllers;

use yii;
use app\models\SupplierT;
use app\models\Supplier;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * SupplierController implements the CRUD actions for SupplierT model.
 */
class SupplierController extends Controller
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
     * Lists all SupplierT models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Supplier();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SupplierT model.
     * @param int $supplier Supplier
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($supplier)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($supplier),
        ]);
    }

    /**
     * Creates a new SupplierT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new SupplierT();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $check = SupplierT::find()->where(['supplier_nama' => $model->supplier_nama])->count();
            if($check > 0){
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
     * Updates an existing SupplierT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $supplier Supplier
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($supplier)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($supplier);
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
     * Deletes an existing SupplierT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $supplier Supplier
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($supplier)
    {
        $this->findModel($supplier)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SupplierT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $supplier Supplier
     * @return SupplierT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($supplier)
    {
        if (($model = SupplierT::findOne($supplier)) !== null) {
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

<?php

namespace app\controllers;

use Yii;
use yii\widgets\ActiveForm;
use app\models\MerekT;
use app\models\Merek;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MerekController implements the CRUD actions for MerekT model.
 */
class MerekController extends Controller
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
     * Lists all MerekT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Merek();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MerekT model.
     * @param int $merek Merek
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($merek)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($merek),
        ]);
    }

    /**
     * Creates a new MerekT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new MerekT();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $check = MerekT::find()->where(['nama' => $model->nama])->count();
            if($check > 0){
                Yii::$app->session->setFlash('warning', 'Nama merek sudah ada, data tidak di simpan!');
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
     * Updates an existing MerekT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $merek Merek
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($merek)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($merek);

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
     * Deletes an existing MerekT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $merek Merek
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($merek)
    {
        $this->findModel($merek)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MerekT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $merek Merek
     * @return MerekT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($merek)
    {
        if (($model = MerekT::findOne(['merek' => $merek])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

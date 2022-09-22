<?php

namespace app\controllers;

use yii;
use app\models\AktivaT;
use app\models\Aktiva;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * AktivaController implements the CRUD actions for AktivaT model.
 */
class AktivaController extends Controller
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
     * Lists all AktivaT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Aktiva();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktivaT model.
     * @param int $aktiva Aktiva
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($aktiva)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($aktiva),
        ]);
    }

    /**
     * Creates a new AktivaT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new AktivaT();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $checkdivisi = AktivaT::find()->where(['aktiva_nama' => $model->aktiva_nama])->count();
            if($checkdivisi > 0){
                Yii::$app->session->setFlash('warning', 'Nama aktiva sudah ada, data tidak di simpan!');
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
     * Updates an existing AktivaT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $aktiva Aktiva
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($aktiva)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($aktiva);
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
     * Deletes an existing AktivaT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $aktiva Aktiva
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($aktiva)
    {
        $this->findModel($aktiva)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AktivaT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $aktiva Aktiva
     * @return AktivaT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($aktiva)
    {
        if (($model = AktivaT::findOne(['aktiva' => $aktiva])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

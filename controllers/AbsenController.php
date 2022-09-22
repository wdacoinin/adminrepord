<?php

namespace app\controllers;

use app\models\AbsenT;
use app\models\Absen;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\widgets\ActiveForm;

/**
 * AbsenController implements the CRUD actions for AbsenT model.
 */
class AbsenController extends Controller
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
     * Lists all AbsenT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Absen();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AbsenT model.
     * @param int $absen Absen
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($absen)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($absen),
        ]);
    }

    /**
     * Creates a new AbsenT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new AbsenT();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $check = AbsenT::find()->where(['nama' => $model->divisi])->count();
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
     * Updates an existing AbsenT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $absen Absen
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($absen)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($absen);

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
     * Deletes an existing AbsenT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $absen Absen
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($absen)
    {
        $this->findModel($absen)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AbsenT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $absen Absen
     * @return AbsenT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($absen)
    {
        if (($model = AbsenT::findOne(['absen' => $absen])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

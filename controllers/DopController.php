<?php

namespace app\controllers;

use Yii;
use yii\widgets\ActiveForm;
use app\models\DopT;
use app\models\Dop;
use app\models\DoProduk;
use app\models\DoProdukT;
use app\models\ProdukT;
use app\models\VariableT;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DopController implements the CRUD actions for DopT model.
 */
class DopController extends Controller
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
     * Lists all DopT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Dop();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DopT model.
     * @param int $do Do
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($do)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($do),
        ]);
    }

    /**
     * Creates a new DopT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new DopT();

        $year = date('Y');
        $checkmax = DopT::find()->where(["DATE_FORMAT(do_tgl,'%Y')" => $year])
        ->count();
        $faktur = 'DO' . date('Ymd') . sprintf("%04s", $checkmax + 1);

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $check = DopT::find()->where(['no_sj' => $model->no_sj])->count();
            if($check > 0){
                Yii::$app->session->setFlash('warning', 'Nota sudah ada, data tidak di simpan!');
            }else{
                $model->us = Yii::$app->user->identity->id;
                if($model->save()) {
                    Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                } else {
                    Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                }
            }
            return $this->redirect(['dopembelian/index']);
        } else {
            $model->faktur = $faktur;
            $model->ppn = 0;
            $model->do_diskon = 0;
            $model->do_status = 'Hutang';
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DopT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $do Do
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($do)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($do);
        $searchModel2 = new DoProduk();
        $dataProvider2 = $searchModel2->search($this->request->queryParams, $do);

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
            return $this->redirect(['dopembelian/index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'searchModel2' => $searchModel2,
                'dataProvider2' => $dataProvider2,
            ]);
        }
    }

    /**
     * Deletes an existing DopT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $do Do
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($do)
    {
        $this->findModel($do)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DopT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $do Do
     * @return DopT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($do)
    {
        if (($model = DopT::findOne(['do' => $do])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

<?php

namespace app\controllers;

use Yii;
use yii\widgets\ActiveForm;
use app\models\ReportT;
use app\models\Report;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReportController implements the CRUD actions for ReportT model.
 */
class ReportController extends Controller
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
     * Lists all ReportT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Report();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReportT model.
     * @param int $report Report
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($report)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($report),
        ]);
    }

    /**
     * Creates a new ReportT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new ReportT();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            $model->report_user = Yii::$app->user->identity->id;
            $model->report_date = date('Y-m-d');
            $model->report_status = 1;
            if($model->save()) {
                Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
            } else {
                Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
            }
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ReportT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $report Report
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($report)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($report);

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
     * Deletes an existing ReportT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $report Report
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($report)
    {
        $this->findModel($report)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ReportT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $report Report
     * @return ReportT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($report)
    {
        if (($model = ReportT::findOne(['report' => $report])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

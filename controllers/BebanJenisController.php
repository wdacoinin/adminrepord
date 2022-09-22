<?php

namespace app\controllers;

use Yii;
use yii\widgets\ActiveForm;
use app\models\BebanJenisT;
use app\models\BebanJenis;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BebanJenisController implements the CRUD actions for BebanJenisT model.
 */
class BebanJenisController extends Controller
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
     * Lists all BebanJenisT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new BebanJenis();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BebanJenisT model.
     * @param int $beban_jenis Beban Jenis
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($beban_jenis)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($beban_jenis),
        ]);
    }

    /**
     * Creates a new BebanJenisT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new BebanJenisT();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $check = BebanJenisT::find()->where(['beban_jenis_nama' => $model->beban_jenis_nama])->count();
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
     * Updates an existing BebanJenisT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $beban_jenis Beban Jenis
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($beban_jenis)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($beban_jenis);
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
     * Deletes an existing BebanJenisT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $beban_jenis Beban Jenis
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($beban_jenis)
    {
        $this->findModel($beban_jenis)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BebanJenisT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $beban_jenis Beban Jenis
     * @return BebanJenisT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($beban_jenis)
    {
        if (($model = BebanJenisT::findOne(['beban_jenis' => $beban_jenis])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

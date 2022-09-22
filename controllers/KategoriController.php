<?php

namespace app\controllers;

use Yii;
use yii\widgets\ActiveForm;
use app\models\KategoriT;
use app\models\Kategori;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KategoriController implements the CRUD actions for KategoriT model.
 */
class KategoriController extends Controller
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
     * Lists all KategoriT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Kategori();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single KategoriT model.
     * @param int $kategori Kategori
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($kategori)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($kategori),
        ]);
    }

    /**
     * Creates a new KategoriT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new KategoriT();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $check = KategoriT::find()->where(['kategori_nama' => $model->kategori_nama])->count();
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
     * Updates an existing KategoriT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $kategori Kategori
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($kategori)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($kategori);
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
     * Deletes an existing KategoriT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $kategori Kategori
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($kategori)
    {
        $this->findModel($kategori)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the KategoriT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $kategori Kategori
     * @return KategoriT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($kategori)
    {
        if (($model = KategoriT::findOne(['kategori' => $kategori])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

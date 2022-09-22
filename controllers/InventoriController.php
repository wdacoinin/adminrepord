<?php

namespace app\controllers;

use Yii;
use yii\widgets\ActiveForm;
use app\models\Lokasi;
use app\models\LokasiT;
use app\models\InventoriT;
use app\models\Inventori;
use Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InventoriController implements the CRUD actions for InventoriT model.
 */
class InventoriController extends Controller
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
     * Lists all InventoriT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Inventori();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $searchModel2 = new Lokasi();
        $dataProvider2 = $searchModel2->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    /**
     * Displays a single InventoriT model.
     * @param int $inventori Inventori
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($inventori)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($inventori),
        ]);
    }

    /**
     * Creates a new InventoriT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new InventoriT();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $check = InventoriT::find()->where(['kode' => $model->kode])->count();
            if($check > 0){
                Yii::$app->session->setFlash('warning', 'Kode inventori sudah ada, data tidak di simpan!');
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
     * Updates an existing InventoriT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $inventori Inventori
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($inventori)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($inventori);

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
     * Deletes an existing InventoriT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $inventori Inventori
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($inventori)
    {
        $model = $this->findModel($inventori);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if($model->delete()){
                $transaction->commit();
                Yii::$app->session->setFlash('sucess', 'Data berhasil dihapus');
            }else{
                $transaction->rollback();
                Yii::$app->session->setFlash('warning', 'Data tidak hapus, hapus dulu semua item yang memakai kode inventori!');
            }
        } catch (Exception $ex) {
            $transaction->rollback();
            Yii::$app->session->setFlash('warning', 'Data tidak hapus, hapus dulu semua item yang memakai kode inventori!');
            //return $this->redirect(['index']);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the InventoriT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $inventori Inventori
     * @return InventoriT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($inventori)
    {
        if (($model = InventoriT::findOne(['inventori' => $inventori])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

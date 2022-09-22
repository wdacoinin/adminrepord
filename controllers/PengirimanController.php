<?php

namespace app\controllers;

use Yii;
use yii\widgets\ActiveForm;
use app\models\PengirimanT;
use app\models\Pengiriman;
use app\models\PenjualanT;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use Exception;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * PengirimanController implements the CRUD actions for PengirimanT model.
 */
class PengirimanController extends Controller
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
     * Lists all PengirimanT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Pengiriman();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PengirimanT model.
     * @param int $pengiriman Pengiriman
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($pengiriman)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($pengiriman),
        ]);
    }

    /**
     * Creates a new PengirimanT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new PengirimanT();

        $year = date('Y');
        $checkmax = PengirimanT::find()->where(["DATE_FORMAT(datetime,'%Y')" => $year])
        ->count();
        $sj = 'SJ' . date('Ymd') . sprintf("%04s", $checkmax + 1);
        $model->surat_jalan = $sj;

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $check = PengirimanT::find()->where(['surat_jalan' => $model->surat_jalan])->count();
            if($check > 0){
                Yii::$app->session->setFlash('warning', 'Surat jalan sudah ada, data tidak di simpan!');
            }else{
                if($model->penjualan > 0){
                    $modPenjualan = PenjualanT::findOne($model->penjualan);
                    $modPenjualan->surat_jalan = $model->surat_jalan;
                    if($model->save() && $modPenjualan->save()) {
                        Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                    } else {
                        Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                    }
                }else{
                    if($model->save()) {
                        Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                    } else {
                        Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                    }
                }
            }
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdategambar($pengiriman)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($pengiriman);
        $UpForm = new UploadForm();
        $UpForm->file = $model->url;

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }            
            
            if ($UpForm->load($this->request->post())) {
                //========================================================================//
                //===========================IMAGE HANDLE=================================//
                $UpForm->file = UploadedFile::getInstance($UpForm, 'file');

                if ($UpForm->file && $UpForm->validate()) {  
                    //$bytes = random_bytes(3);
                    $ran = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,3);
                    $upload_dir = Yii::getAlias('@webroot') . '/uploads/pengiriman/';
                    //var_dump($upload_dir);die;

                    if (!file_exists($upload_dir)) //Buat folder bername temp
                    //mkdir($upload_dir);
                    FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

                    //image
                    $img = $UpForm->file;
                    //get filesize
                    $file_size = $UpForm->file->size;
                    $url_database = Yii::$app->request->baseUrl . '/uploads/pengiriman/' . $model->surat_jalan . '-' . $ran . '.' . $UpForm->file->extension;
                    $nama_foto = $model->surat_jalan . "-" . $ran . '.' . $UpForm->file->extension;

                    //save to directori 'upload/doc_penj/'
                    //file_put_contents($file_to_put, $data);
                    $UpForm->file->saveAs($upload_dir . $nama_foto);
                    //set it to model
                    $model->nama_foto = $nama_foto;
                    $model->type = $UpForm->file->extension;
                    $model->size = $file_size;
                    $model->url = $url_database;
            
                    if($model->save()) {
                        Yii::$app->session->setFlash('success', 'Data berhasil update!');
                    } else {
                        Yii::$app->session->setFlash('error', 'Data tidak berhasil di update');
                    }
                }else{
                    Yii::$app->session->setFlash('error', 'Data tidak berhasil di update, tidak ada gambar');
                }
                //========================================================================//
                //===========================IMAGE HANDLE=================================//
            }
            return $this->redirect(['index']);
        } else {
            if($model->nama_foto != NULL){
                $action = 1;
            }else{
                $action = 0;
            }
            return $this->renderAjax('updategambar', [
                'model' => $model,
                'action' => $action,
                'UpForm' => $UpForm,
            ]);
        }
    }

    /** $id_img, $penjualan
     * @return mixed 
     */
    public function actionDeletefile()
    {
        $file_key = (int)\Yii::$app->request->post('key');

        echo json_encode($file_key);
        
        $PengirimanT = PengirimanT::findOne($file_key);

        $exp = explode('/',$PengirimanT->url,3);
        
        $upload_dir = Yii::getAlias('@webroot') . '/' . $exp[2];
        
        $PengirimanT->nama_foto = '';
        $PengirimanT->type = '';
        $PengirimanT->size = '';
        $PengirimanT->url = '';
        if($PengirimanT->save()){
            unlink($upload_dir);
        }
        
    }

    /**
     * Updates an existing PengirimanT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $pengiriman Pengiriman
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($pengiriman)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($pengiriman);
        $modPenj = PenjualanT::find()->where(['surat_jalan' => $model->surat_jalan])->asArray()->one();
        
        if($modPenj != null){
            $model->penjualan = $modPenj['penjualan'];
        }

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
     * Deletes an existing PengirimanT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $pengiriman Pengiriman
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($pengiriman)
    {
        $this->findModel($pengiriman)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PengirimanT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $pengiriman Pengiriman
     * @return PengirimanT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($pengiriman)
    {
        if (($model = PengirimanT::findOne(['pengiriman' => $pengiriman])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

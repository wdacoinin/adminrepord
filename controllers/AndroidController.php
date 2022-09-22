<?php

namespace app\controllers;

use yii;
use app\models\BackendUser;
use app\models\DoProdukSG;
use app\models\Pengiriman;
use app\models\PengirimanM;
use app\models\PengirimanT;
use app\models\PenjualanT;
use app\models\SBackendUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Security;
use yii\widgets\ActiveForm;
use app\models\UploadForm;
use Exception;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * BackendUserController implements the CRUD actions for BackendUser model.
 */
class AndroidController extends Controller
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
     * Lists all BackendUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'mobile';
        return $this->render('index');
    }

    /**
     * Lists all BackendUser models.
     * @return mixed
     */
    public function actionStok()
    {
        $this->layout = 'mobile';
        $searchModel = new DoProdukSG();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('_stokglobal', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all BackendUser models.
     * @return mixed
     */
    public function actionPengiriman()
    {
        $this->layout = 'mobile';
        if(isset($_GET['user'])){
            $user = $_GET['user'];
        }else{
            $user = null;
        }

        $searchModel = new PengirimanM();
        $dataProvider = $searchModel->search($this->request->queryParams, $user);

        return $this->render('_pengiriman', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdategambar($pengiriman)
    {
        $this->layout = 'kosong';
        $model = PengirimanT::findOne($pengiriman);
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
                    /* if(isset($_GET['lat']) && $_GET['lat'] != '' && isset($_GET['lon'])){
                        $model->lat = $_GET['lat'];
                        $model->lon = $_GET['lon'];
                    } */
            
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
            return $this->redirect(['pengiriman']);
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

    /**
     * Lists all BackendUser models.
     * @return mixed
     */
    public function actionAmbilfoto()
    {
        $this->layout = 'mobile';

        return $this->render('ambilfoto');
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
        $model = PengirimanT::findOne($pengiriman);
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
            return $this->redirect(['pengiriman']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }
}

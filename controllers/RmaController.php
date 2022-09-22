<?php

namespace app\controllers;

use app\models\ProdukT;
use Yii;
use yii\widgets\ActiveForm;
use app\models\RmaT;
use app\models\Rma;
use app\models\RmaItem;
use app\models\RmaItemT;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use Exception;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * RmaController implements the CRUD actions for RmaT model.
 */
class RmaController extends Controller
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
     * Lists all RmaT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Rma();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RmaT model.
     * @param int $rma Rma
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($rma)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($rma),
        ]);
    }

    /**
     * Creates a new RmaT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new RmaT();
        $model->rma_status = 'Proses';
        $UpForm = new UploadForm();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }  
            
            if($model->nama_foto == ''){
                //========================================================================//
                //===========================IMAGE HANDLE=================================//
                $UpForm->file = UploadedFile::getInstance($UpForm, 'file');

                if ($UpForm->file && $UpForm->validate()) {  
                    //$bytes = random_bytes(3);
                    $ran = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,3);
                    $upload_dir = Yii::getAlias('@webroot') . '/uploads/rma/' . $model->rma . '/';
                    //var_dump($upload_dir);die;

                    if (!file_exists($upload_dir)) //Buat folder bername temp
                    //mkdir($upload_dir);
                    FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

                    //image
                    $img = $UpForm->file;
                    //get filesize
                    $file_size = $UpForm->file->size;
                    $url_database = Yii::$app->request->baseUrl . '/uploads/rma/' . $model->rma . '/' . $model->rma . "-" . $ran . '.' . $UpForm->file->extension;
                    $nama_foto = $model->rma . "-" . $ran . '.' . $UpForm->file->extension;

                    //save to directori 'upload/doc_penj/'
                    //file_put_contents($file_to_put, $data);
                    $UpForm->file->saveAs($upload_dir . $nama_foto);
                    //set it to model
                    $model->nama_foto = $nama_foto;
                    $model->type = $UpForm->file->extension;
                    $model->size = $file_size;
                    $model->url = $url_database;
                }
                //========================================================================//
                //===========================IMAGE HANDLE=================================//
            }
            $model->id_user = Yii::$app->user->identity->id;
            if($model->save()) {          
                Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
            } else {
                Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
            }
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'UpForm' => $UpForm,
            ]);
        }
    }

    /**
     * Updates an existing RmaT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $rma Rma
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($rma)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($rma);
        $searchModel = new RmaItem();
        $dataProvider = $searchModel->search($this->request->queryParams, $rma);

        return $this->render('update', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateproduk($rma)
    {
        $this->layout = 'kosong';
        $model = new RmaItemT();
        $model->rma = (int) $rma;
        $UpForm = new UploadForm();
        
        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);

            }

            $transaction = Yii::$app->db->beginTransaction();
            try {

                if ($UpForm->load($this->request->post())) {
                    //========================================================================//
                    //===========================IMAGE HANDLE=================================//
                    $UpForm->file = UploadedFile::getInstance($UpForm, 'file');
    
                    if ($UpForm->file && $UpForm->validate()) {  
                    //$bytes = random_bytes(3);
                    $ran = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,3);
                    $upload_dir = Yii::getAlias('@webroot') . '/uploads/rma/' . $model->rma . '/';
    
                    if (!file_exists($upload_dir)) //Buat folder
                    //mkdir($upload_dir);
                    FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);
    
                    //image
                    $img = $UpForm->file;
                    //get filesize
                    $file_size = $UpForm->file->size;
                    //set build directory
                    $url_database = Yii::$app->request->baseUrl . '/uploads/rma/' . $model->rma . '/' . $model->rma . "-" . $ran . '.' . $UpForm->file->extension;
                    $nama_foto = $model->rma . "-" . $ran . '.' . $UpForm->file->extension;
    
                    //save to directori 'uploads/doc_penj/'
                    $UpForm->file->saveAs($upload_dir . $nama_foto);
                    //set it to model
                    $model->nama_foto = $nama_foto;
                    $model->type = $UpForm->file->extension;
                    $model->size = $file_size;
                    $model->url = $url_database;
                    }
                    $model->produk = (int) $model->produk;
                    $model->rma_jml = (int) $model->rma_jml;
                    $model->rma_harga = (int) $model->rma_harga;
                    $model->id_user = Yii::$app->user->identity->id;
                    
                    //========================================================================//
                    //===========================IMAGE HANDLE=================================//
                    //var_dump($model->attributes);die;
                    if($model->save()) {
                            $transaction->commit();
                            Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                    } else {
                        $transaction->rollback();
                        Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                    }
                }
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('warning', 'Error update barang rakitan');
                $transaction->rollback();
            }
            
            return $this->redirect(['update', 'rma' => $model->rma]);
            //return;
        } else {
            return $this->renderAjax('createproduk', [
                'model' => $model,
                'UpForm' => $UpForm
            ]);
        }
    }

    public function actionUpdateproduk($rma_item)
    {
        $this->layout = 'kosong';
        $model = RmaItemT::findOne($rma_item);
        $UpForm = new UploadForm();
        
        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);

            }

            $transaction = Yii::$app->db->beginTransaction();
            try {

                if ($UpForm->load($this->request->post())) {
                    //========================================================================//
                    //===========================IMAGE HANDLE=================================//
                    $UpForm->file = UploadedFile::getInstance($UpForm, 'file');
    
                    if ($UpForm->file && $UpForm->validate()) {  
                    //$bytes = random_bytes(3);
                    $ran = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,3);
                    $upload_dir = Yii::getAlias('@webroot') . '/uploads/rma/' . $model->rma . '/';
    
                    if (!file_exists($upload_dir)) //Buat folder
                    //mkdir($upload_dir);
                    FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);
    
                    //image
                    $img = $UpForm->file;
                    //get filesize
                    $file_size = $UpForm->file->size;
                    //set build directory
                    $url_database = Yii::$app->request->baseUrl . '/uploads/rma/' . $model->rma . '/' . $model->rma . "-" . $ran . '.' . $UpForm->file->extension;
                    $nama_foto = $model->rma . "-" . $ran . '.' . $UpForm->file->extension;
    
                    //save to directori 'uploads/doc_penj/'
                    $UpForm->file->saveAs($upload_dir . $nama_foto);
                    //set it to model
                    $model->nama_foto = $nama_foto;
                    $model->type = $UpForm->file->extension;
                    $model->size = $file_size;
                    $model->url = $url_database;
                    }
                    $model->produk = (int) $model->produk;
                    $model->rma_jml = (int) $model->rma_jml;
                    $model->rma_harga = (int) $model->rma_harga;
                    $model->id_user = Yii::$app->user->identity->id;
                    
                    //========================================================================//
                    //===========================IMAGE HANDLE=================================//
                    //var_dump($model->attributes);die;
                    if($model->save()) {
                            $transaction->commit();
                            Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                    } else {
                        $transaction->rollback();
                        Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                    }
                }
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('warning', 'Error update barang rakitan');
                $transaction->rollback();
            }
            
            return $this->redirect(['update', 'rma' => $model->rma]);
            //return;
        } else {
            return $this->renderAjax('updateproduk', [
                'model' => $model,
                'UpForm' => $UpForm
            ]);
        }
    }

    public function actionAproduk()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->layout = 'api';
        $prop = $_POST['depdrop_parents'];
        $merek =$prop[0];
        if (isset($_POST['depdrop_params']) && !empty($_POST['depdrop_params'])) {
            $params = $_POST['depdrop_params'];
            $kategori = $params[0];
        }

        //var_dump($day);die;
        $produk = ProdukT::find()->select('
        produk, 
        nama')
        ->where(['kategori' => $kategori, 'merek' => $merek])
        ->distinct('produk.produk')
        ->asArray()->all();

        $dt=[];
        $selected='';
        if($produk != null){

            $data=[];
            foreach($produk as $row){
                $data[] = array(
                    'id' => $row['produk'],
                    'name' => $row['nama'],
                );
                $selected = $data;
            } 
            $dt = $data;
            
            //return $data;
        }
        return ['output'=> $dt, 'selected'=>''];
    }

    public function actionDeletefileproduk()
    {
        $file_key = (int)\Yii::$app->request->post('key');

        echo json_encode($file_key);
        
        $DoProduk = RmaItemT::findOne($file_key);

        $exp = explode('/',$DoProduk->url,3);
        var_dump($exp);die;
        
        $upload_dir = Yii::getAlias('@webroot') . '/' . $exp[2];

            
        if(unlink($upload_dir)){
            $DoProduk->nama_foto = '';
            $DoProduk->type = '';
            $DoProduk->size = '';
            $DoProduk->url = '';
            $DoProduk->save();
        }

    }

    public function actionUpload($rma)
    {
        $this->layout = 'kosong';
        $model = RmaT::findOne($rma);
        $UpForm = new UploadForm();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($UpForm->load($this->request->post())) {
                    //========================================================================//
                    //===========================IMAGE HANDLE=================================//
                    $UpForm->file = UploadedFile::getInstance($UpForm, 'file');

                    if ($UpForm->file && $UpForm->validate()) {  
                    //$bytes = random_bytes(3);
                    $ran = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,3);
                    $upload_dir = Yii::getAlias('@webroot') . '/uploads/rma/' . $model->rma . '/';

                    if (!file_exists($upload_dir)) //Buat folder
                    //mkdir($upload_dir);
                    FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

                    //image
                    $img = $UpForm->file;
                    //get filesize
                    $file_size = $UpForm->file->size;
                    //set build directory
                    $url_database = Yii::$app->request->baseUrl . '/uploads/rma/' . $model->rma . '/' . $model->rma . "-" . $ran . '.' . $UpForm->file->extension;
                    $nama_foto = $model->rma . "-" . $ran . '.' . $UpForm->file->extension;

                    //save to directori 'uploads/doc_penj/'
                    $UpForm->file->saveAs($upload_dir . $nama_foto);
                    //set it to model
                    $model->nama_foto = $nama_foto;
                    $model->type = $UpForm->file->extension;
                    $model->size = $file_size;
                    $model->url = $url_database;
                    }
                    
                    //========================================================================//
                    //===========================IMAGE HANDLE=================================//
                    //var_dump($model->attributes);die;
                    if($model->save()) {
                            $transaction->commit();
                            Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                    } else {
                        $transaction->rollback();
                        Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                    }
                }
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('warning', 'Error update barang rakitan');
                $transaction->rollback();
            }
            //return $this->redirect(Url::to(['tracking-order/index']));
            return $this->redirect(['update', 'rma' => $rma]);
        } else {
            return $this->renderAjax('upload', [
                'model' => $model,
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
        
        $DocRmaT = RmaT::findOne($file_key);

        $exp = explode('/',$DocRmaT->url,3);
        
        $upload_dir = Yii::getAlias('@webroot') . '/' . $exp[2];
            
        if(unlink($upload_dir)){
            $DocRmaT->nama_foto = NULL;
            $DocRmaT->url = NULL;
            $DocRmaT->type = NULL;
            $DocRmaT->size = 0;
            $DocRmaT->save();
        }

    }

    /**
     * Deletes an existing RmaT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $rma Rma
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($rma)
    {
        $model = $this->findModel($rma);
        try {
            if($model->delete()){
                Yii::$app->session->setFlash('sucess', 'Data berhasil dihapus');
            }else{
                Yii::$app->session->setFlash('warning', 'Data tidak hapus, hapus dulu semua item yang ada di RMA');
            }
        } catch (Exception $ex) {
            //$transaction->rollback();
            Yii::$app->session->setFlash('warning', 'Data tidak hapus, hapus dulu semua item yang ada di RMA');
            return $this->redirect(['index']);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the RmaT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $rma Rma
     * @return RmaT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($rma)
    {
        if (($model = RmaT::findOne(['rma' => $rma])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

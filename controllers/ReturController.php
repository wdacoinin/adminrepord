<?php

namespace app\controllers;

use app\models\DoProdukOnNota;
use app\models\DoProdukOnRetur;
use app\models\DoProdukT;
use app\models\DopT;
use app\models\ProdukT;
use Yii;
use yii\widgets\ActiveForm;
use app\models\ReturT;
use app\models\Retur;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use Exception;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * ReturController implements the CRUD actions for ReturT model.
 */
class ReturController extends Controller
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
     * Lists all ReturT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Retur();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReturT model.
     * @param int $retur Retur
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($retur)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($retur),
        ]);
    }

    /**
     * Creates a new ReturT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new ReturT();
        $UpForm = new UploadForm();

        $year = date('Y');
        $checkmax = ReturT::find()->where(["DATE_FORMAT(date,'%Y')" => $year])
        ->count();
        $noretur = 'RET' . date('Ymd') . sprintf("%04s", $checkmax + 1);
        $model->noretur = $noretur;

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
                    $upload_dir = Yii::getAlias('@webroot') . '/uploads/retur/';
                    //var_dump($upload_dir);die;

                    if (!file_exists($upload_dir)) //Buat folder bername temp
                    //mkdir($upload_dir);
                    FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

                    //image
                    $img = $UpForm->file;
                    //get filesize
                    $file_size = $UpForm->file->size;
                    $url_database = Yii::$app->request->baseUrl . '/uploads/retur/' . $model->noretur . "-" . $ran . '.' . $UpForm->file->extension;
                    $nama_foto = $model->noretur . "-" . $ran . '.' . $UpForm->file->extension;

                    //save to directori 'upload/doc_penj/'
                    //file_put_contents($file_to_put, $data);
                    $UpForm->file->saveAs($upload_dir . $nama_foto);
                    //set it to model
                    $model->nama_foto = $nama_foto;
                    $model->type = $UpForm->file->extension;
                    $model->size = $file_size;
                    $model->url = $url_database;
                    //========================================================================//
                    //===========================IMAGE HANDLE=================================//
            
    
                    if($model->save()) {
                        Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                    } else {
                        Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                    }
                }else{
                    Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan, gambar tidak ada');
                }
            }
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'UpForm' => $UpForm,
            ]);
        }
    }

    public function actionUpdategambar($retur)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($retur);
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
                    $upload_dir = Yii::getAlias('@webroot') . '/uploads/retur/';
                    //var_dump($upload_dir);die;

                    if (!file_exists($upload_dir)) //Buat folder bername temp
                    //mkdir($upload_dir);
                    FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

                    //image
                    $img = $UpForm->file;
                    //get filesize
                    $file_size = $UpForm->file->size;
                    $url_database = Yii::$app->request->baseUrl . '/uploads/retur/' . $model->noretur . '-' . $ran . '.' . $UpForm->file->extension;
                    $nama_foto = $model->noretur . "-" . $ran . '.' . $UpForm->file->extension;

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
            return $this->renderAjax('updategambar', [
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
        
        $ReturT = ReturT::findOne($file_key);

        $exp = explode('/',$ReturT->url,3);
        
        $upload_dir = Yii::getAlias('@webroot') . '/' . $exp[2];
        
        $ReturT->nama_foto = '';
        $ReturT->type = '';
        $ReturT->size = '';
        $ReturT->url = '';
        if($ReturT->save()){
            unlink($upload_dir);
        }
        
    }

    /**
     * Updates an existing ReturT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $retur Retur
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($retur)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($retur);
        $searchModel = new DoProdukOnRetur();
        $dataProvider = $searchModel->search($this->request->queryParams, $retur);


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
            return $this->redirect(['update', 'retur' => $retur]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'searchModel' => $searchModel, 
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionCari($retur)
    {
        $this->layout = 'kosong';
        $model = ReturT::findOne($retur);
        $searchModel = new DoProdukOnRetur();
        $dataProvider = $searchModel->search($this->request->queryParams, $retur);
        
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            $modProduk = DoProdukT::findOne($model->do_produk);
            if((int) $model->qty_retur > 0){
                
                //pisah inventori yang di ambil oleh retur
                $split = new DoProdukT();
                $split->do = $modProduk->do;
                $split->produk = $modProduk->produk;
                $split->stok_jenis = $modProduk->stok_jenis;
                $split->do_jml = (int) $model->qty_retur;
                $split->jml_now = (int) $model->qty_retur;
                $split->do_harga = (int) $modProduk->do_harga;
                $split->harga_jual = (int) $modProduk->harga_jual;
                $split->do_produk_status = 3;
                $split->do_produk_date = $modProduk->do_produk_date;
                $split->timestamp = date('Y-m-d H:m:i');
                $split->do_produk_origin = $modProduk->do_produk;
                $split->inventori = 101;
                $split->retur = $model->retur;
                $split->nama_foto = $modProduk->nama_foto;
                $split->type = $modProduk->type;
                $split->size = $modProduk->size;
                $split->url = $modProduk->url;
                //var_dump($split->validate());die;

                if($split->save()) {
                    Yii::$app->session->setFlash('success', 'Data berhasil update!');
                } else {
                    Yii::$app->session->setFlash('error', 'Data tidak berhasil di update');
                }

            }
            return $this->redirect(['update', 'retur' => $retur]);
        }
        return $this->renderAjax('cari', [
            'model' => $model 
        ]);
    }
    
    public function actionUpdateproduk($do_produk)
    {
        $this->layout = 'kosong';
        $model = DoProdukT::findOne($do_produk);
        $modRetur = ReturT::findOne($model->retur);
        $searchModel = new DoProdukOnRetur();
        $dataProvider = $searchModel->search($this->request->queryParams, $model->retur);
        
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if((int) $model->do_produk_status == 4){
                $model->jml_now = 0;
                $modRetur->retur_status = 4;

                if($model->save() && $modRetur->save()){
                    Yii::$app->session->setFlash('success', 'Data berhasil update!');
                }else{
                    Yii::$app->session->setFlash('warning', 'Data gagal di update!');
                }

            }elseif((int) $model->do_produk_status == 5){
                    $model->jml_now = 0;
                    $modRetur->retur_status = 3;
    
                    if($model->save() && $modRetur->save()){
                        Yii::$app->session->setFlash('success', 'Data berhasil update!');
                    }else{
                        Yii::$app->session->setFlash('warning', 'Data gagal di update!');
                    }
                    
                
            }else{
                $model->jml_now = $model->do_jml;
                $model->save();
                $modRetur->retur_status = 1;
                
                if($model->save() && $modRetur->save()){
                    Yii::$app->session->setFlash('success', 'Data berhasil update!');
                }else{
                    Yii::$app->session->setFlash('warning', 'Data gagal di update!');
                }
            }

            return $this->redirect(['update', 'retur' => $model->retur]);

        }else{
            return $this->renderAjax('_formproduk', [
                'model' => $model 
            ]);
        }
    }

    public function actionDeleteproduk($do_produk)
    {
        $model = DoProdukT::findOne($do_produk);
        $retur = $model->retur;
        $model->delete();

        return $this->redirect(['update', 'retur' => $retur]);
    }

    /**
     * Deletes an existing ReturT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $retur Retur
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($retur)
    {
        $this->findModel($retur)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ReturT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $retur Retur
     * @return ReturT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($retur)
    {
        if (($model = ReturT::findOne(['retur' => $retur])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

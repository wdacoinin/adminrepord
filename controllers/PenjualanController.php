<?php

namespace app\controllers;

use app\models\AkunSaldoPj;
use app\models\AkunSaldoT;
use app\models\BackendUser;
use app\models\DocPenjT;
use app\models\DoProdukT;
use app\models\DopT;
use app\models\KonsumenT;
use Yii;
use app\models\PenjualanT;
use app\models\Penjualan;
use app\models\PenjualanOnNota;
use app\models\PenjualanProdukT;
use app\models\PenjualanProdukTtOnNota;
use app\models\PenjualanProdukTtT;
use app\models\Penjualans;
use app\models\Penjualanv;
use app\models\RakitanT;
use app\models\UploadForm;
use app\models\VariableT;
use app\models\WoProdukT;
use app\models\WoT;
use Exception;
use kartik\mpdf\Pdf;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * PenjualanController implements the CRUD actions for PenjualanT model.
 */
class PenjualanController extends Controller
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
     * Lists all PenjualanT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Penjualans();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PenjualanT model.
     * @param int $penjualan Penjualan
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($penjualan)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($penjualan),
        ]);
    }

    /**
     * Creates a new PenjualanT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new PenjualanT();
        $model->penjualan_ongkir = 0;
        $model->penjualan_diskon = 0;
        $model->penjualan_type = 'Umum';
        $model->fee = 0;
        $model->akun = 4;

        $year = date('Y');
        $checkmax = PenjualanT::find()->where(["DATE_FORMAT(penjualan_tgl,'%Y')" => $year])
        ->count();
        $faktur = 'MJ' . date('Ymd') . sprintf("%04s", $checkmax + 1);

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            //var_dump($model->attributes);die;
            if($model->konsumen_nama != '' && $model->konsumen_telp != ''){
                $kons = new KonsumenT();
                $kons->konsumen_nama = $model->konsumen_nama;
                $kons->konsumen_telp = $model->konsumen_telp;
                if ($kons->save()) {
                    $model->konsumen = $kons->konsumen;
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Berhasil simpan penjualan');
                    }else{
                        Yii::$app->session->setFlash('warning', 'Gagal simpan penjualan');
                    }
                }else{
                    Yii::$app->session->setFlash('warning', 'Gagal simpan penjualan');
                }
            }else{
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Berhasil simpan penjualan');
                }else{
                    Yii::$app->session->setFlash('warning', 'Gagal simpan penjualan');
                }
            }

            
            return $this->redirect(['penjualan/index']);
        } else {
            //var_dump($model->rakitan);die;
            $model->faktur = $faktur;
            $model->penjualan_status = 'Piutang';
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PenjualanT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $penjualan Penjualan
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($penjualan)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($penjualan);
        $modTotal = Penjualanv::findOne($penjualan);
        $searchModel2 = new PenjualanOnNota();
        $dataProvider2 = $searchModel2->search($this->request->queryParams, $penjualan);
        $searchModel3 = new AkunSaldoPj();
        $dataProvider3 = $searchModel3->search($this->request->queryParams, 10, $penjualan);
        $searchModel4 = new PenjualanProdukTtOnNota();
        $dataProvider4 = $searchModel4->search($this->request->queryParams, $penjualan);
        $DocPenj = new DocPenjT();
        $DocKonsumen = DocPenjT::find()->where(['doc' => 'Konsumen'])->asArray()->count();
        $DocBarang = DocPenjT::find()->where(['doc' => 'Barang'])->asArray()->count();
        $DocTransaksi = DocPenjT::find()->where(['doc' => 'Transaksi'])->asArray()->count();
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
            
            return $this->redirect(['update', 'penjualan' => $model->penjualan]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modTotal' => $modTotal,
                'DocPenj' => $DocPenj,
                'DocKonsumen' => $DocKonsumen,
                'DocBarang' => $DocBarang,
                'DocTransaksi' => $DocTransaksi,
                'searchModel2' => $searchModel2, 
                'dataProvider2' => $dataProvider2,
                'searchModel3' => $searchModel3,
                'dataProvider3' => $dataProvider3,
                'searchModel4' => $searchModel4,
                'dataProvider4' => $dataProvider4,
            ]);
        }
    }

    public function actionUpload($penjualan)
    {
        $this->layout = 'kosong';
        $modPenjualan = PenjualanT::findOne($penjualan);
        $DocPenj =new DocPenjT();
        $UpForm = new UploadForm();
        $DocPenj->penjualan = (int) $penjualan;

        //validation
        if ($DocPenj->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($DocPenj);
            }

            $DocPenj->penjualan = (int) $penjualan;
            if ($UpForm->load($this->request->post())) {
                    
                    //========================================================================//
                    //===========================IMAGE HANDLE=================================//
                    $UpForm->file = UploadedFile::getInstance($UpForm, 'file');

                    if ($UpForm->file && $UpForm->validate()) {  
                    //$bytes = random_bytes(3);
                    $ran = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,3);
                    $upload_dir = Yii::getAlias('@webroot') . '/uploads/doc_penj/' . $modPenjualan->faktur . '/';

                    if (!file_exists($upload_dir)) //Buat folder
                    //mkdir($upload_dir);
                    FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

                    //image
                    $img = $UpForm->file;
                    //get filesize
                    $file_size = $UpForm->file->size;
                    //set build directory
                    $url_database = Yii::$app->request->baseUrl . '/uploads/doc_penj/' . $modPenjualan->faktur . '/' . $UpForm->file->name . '.' . $UpForm->file->extension;
                    $nama_foto = $UpForm->file->name . '.' . $UpForm->file->extension;

                    //save to directori 'uploads/doc_penj/'
                    $UpForm->file->saveAs($upload_dir . $nama_foto);
                    //set it to model
                    $DocPenj->nama_foto = $UpForm->file->name;
                    $DocPenj->type = $UpForm->file->extension;
                    $DocPenj->size = $file_size;
                    $DocPenj->url = $url_database;
                    }
                    //var_dump($DocPenj->attributes);die;
                    //========================================================================//
                    //===========================IMAGE HANDLE=================================//
                    if($DocPenj->save()) {
                        Yii::$app->session->setFlash('success', 'File berhasil disimpan!');
                    } else {
                        Yii::$app->session->setFlash('danger', 'File tidak berhasil di input');
                    }
            }
            //return $this->redirect(Url::to(['tracking-order/index']));
            return $this->redirect(['update', 'penjualan' => $modPenjualan->penjualan]);
        } else {
            return $this->renderAjax('upload', [
                'modPenjualan' => $modPenjualan,
                'DocPenj' => $DocPenj,
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
        
        $DocPenj = DocPenjT::findOne($file_key);

        $exp = explode('/',$DocPenj->url,3);
        
        $upload_dir = Yii::getAlias('@webroot') . '/' . $exp[2];
            
        if(unlink($upload_dir)){
            $DocPenj->delete();
        }

    }

    public function actionCreateproduk($penjualan)
    {
        $this->layout = 'kosong';
        $model = new PenjualanProdukT();
        $model->penjualan = $penjualan;
        
        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);

            }
            $modProduk = DoProdukT::findOne($model->do_produk);

            $model->produk = $modProduk->produk;
            $model->penjualan = (int) $penjualan;
            //$model->penjualan_hpp = (int) $modProduk->do_harga;
            $model->user_input  = Yii::$app->user->identity->id;
            $model->penjualan_hpp =  round( (int) $modProduk->do_harga, 0);
            
            if($model->validate()){
                $check = PenjualanProdukT::find()->where(['penjualan' => $penjualan, 'produk' => $model->produk, 'penjualan_harga' => $model->penjualan_harga])->count();
                if($check > 0){
                    Yii::$app->session->setFlash('warning', 'Produk sudah ada, update di produk tersebut, data tidak di simpan!');
                }else{

                    
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        //check apakah tipe penjualan rakitan pc
                        $checkrakitan = PenjualanProdukT::find()
                        ->select('do_produk.rakitan, do_produk.inventori')
                        ->join("LEFT JOIN", "do_produk", "penjualan_produk.do_produk=do_produk.do_produk")
                        ->where(['penjualan_produk.penjualan' => $penjualan])
                        ->andWhere('do_produk.rakitan > 0')
                        ->asArray()->one();

                        //var_dump($checkrakitan['rakitan']);die;

                        //jika penjualan rakitan
                        if($checkrakitan != null){
                            $rakitan = (int) $checkrakitan['rakitan'];
                            $inventori = (int) $checkrakitan['inventori'];
                            //check sisa stok
                                $sisa_stok = $modProduk->jml_now - $model->penjualan_jml;
                                if($sisa_stok > 0){

                                    //pisah inventori yang di ambil oleh penjualan tipe rakitan
                                    $split = new DoProdukT();
                                    $split->do = $modProduk->do;
                                    $split->produk = $modProduk->produk;
                                    $split->stok_jenis = $modProduk->stok_jenis;
                                    $split->do_jml = $model->penjualan_jml;
                                    $split->jml_now = 0;
                                    $split->do_harga = $modProduk->do_harga;
                                    $split->harga_jual = $model->penjualan_harga;
                                    $split->do_produk_status = 2;
                                    $split->do_produk_date = $modProduk->do_produk_date;
                                    $split->timestamp = date('Y-m-d H:m:i');
                                    $split->do_produk_origin = $modProduk->do_produk;
                                    $split->inventori = $inventori;
                                    $split->rakitan = $rakitan;

                                    $modProduk->jml_now = $sisa_stok;
                                    if($split->save()) {
                                        $model->do_produk = $split->do_produk;
                                    
                                        if($model->save() && $modProduk->save()){
                                            $transaction->commit();
                                            Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                                        }else{
                                            $transaction->rollback();
                                            Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                                        }
                                    } else {
                                        $transaction->rollback();
                                        Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                                    }
                                }else{
                                    $modProduk->jml_now = 0;
                                    $modProduk->do_produk_status = 2;
                                    $modProduk->inventori = $inventori;
                                    $modProduk->rakitan = $rakitan;
                                
                                    if($model->save()) {
                                        if($modProduk->save()){
                                            $transaction->commit();
                                            Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                                        }else{
                                            $transaction->rollback();
                                            Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                                        }
                                    } else {
                                        $transaction->rollback();
                                        Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                                    }
                                }


                        //jika bukan penjualan rakitan
                        }else{
                            if($model->save()) {
                                $sisa_stok = $modProduk->jml_now - $model->penjualan_jml;
                                if($sisa_stok > 0){
                                    $modProduk->jml_now = $sisa_stok;
                                }else{
                                    $modProduk->jml_now = 0;
                                    $modProduk->do_produk_status = 2;
                                }
                                
                                if($modProduk->save()){
                                    $transaction->commit();
                                    Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                                }else{
                                    $transaction->rollback();
                                    Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                                }
                            } else {
                                $transaction->rollback();
                                Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                            }
                        }

                    } catch (Exception $ex) {
                        Yii::$app->session->setFlash('warning', 'Error update barang rakitan');
                        $transaction->rollback();
                    }
                }
            }else{
                Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
            }
            
            return $this->redirect(['update', 'penjualan' => $model->penjualan]);
            //return;
        } else {
            return $this->renderAjax('createproduk', [
                'model' => $model,
            ]);
        }
    }

    public function actionQty(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->layout = 'api';
        $do_produk = $_POST['do_produk'];
        $produk = DoProdukT::findOne($do_produk);
        $returcount = DoProdukT::find()->where(['do_produk_origin' => $do_produk])->andWhere('retur > 0 AND jml_now > 0')->count();

        if($returcount > 0){
            $stokorigin = DoProdukT::find()->select('SUM(jml_now) AS jml_now')->where(['do_produk_origin' => $do_produk])->andWhere('retur > 0 AND jml_now > 0')->asArray()->one();
            if($stokorigin != NULL && $stokorigin['jml_now'] > 0){
                $jml_now = $produk->jml_now - (int) $stokorigin['jml_now'];
            }else{
                $jml_now = $produk->jml_now;
            }
        }else{
            $jml_now = $produk->jml_now;
        }

        $data = array(
            'hasil' => 'success',
            'jml_now' => $jml_now,
            'harga_jual' => $produk->harga_jual
        );
        return $data;
    }

    public function actionCreateprodukrakitan($penjualan)
    {
        $this->layout = 'kosong';
        $model = new PenjualanProdukT();
        $model->penjualan = $penjualan;
        
        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);

            }
            $modProdukRakitan = DoProdukT::find()->where(['rakitan' => $model->rakitan])->asArray()->all();
            $countrak = DoProdukT::find()->where(['rakitan' => $model->rakitan])->asArray()->count();
            $no = 0;
            //var_dump($modProdukRakitan);die;
            $transaction = Yii::$app->db->beginTransaction();
            try {

                foreach($modProdukRakitan as $rowModProduk){
                    $imodel = new PenjualanProdukT();
                    $imodel->do_produk = (int) $rowModProduk['do_produk'];
                    $imodel->produk = (int) $rowModProduk['produk'];
                    $imodel->penjualan = (int) $penjualan;
                    $imodel->user_input  = Yii::$app->user->identity->id;
                    $imodel->penjualan_jml = (int) $rowModProduk['jml_now'];
                    $imodel->penjualan_hpp =  round( (int) $rowModProduk['do_harga'], 0);
                    $imodel->penjualan_harga =  round( (int) $rowModProduk['harga_jual'], 0);
                    $modProduk = DoProdukT::findOne($rowModProduk['do_produk']);


                    //if($imodel->validate()){
                        $check = PenjualanProdukT::find()->where(['penjualan' => $penjualan, 'do_produk' => $imodel->do_produk, 'penjualan_harga' => $imodel->penjualan_harga])->count();
                        if($check > 0){
                            //var_dump($check);die;
                            $transaction->rollback();
                            Yii::$app->session->setFlash('warning', 'Produk sudah ada, update di produk tersebut, data tidak di simpan!');
                        }else{
        
                                //var_dump($imodel->attributes);die;
                                if($imodel->save()) {

                                    $sisa_stok = $modProduk->jml_now - $imodel->penjualan_jml;
                                    if($sisa_stok > 0){
                                        $modProduk->jml_now = $sisa_stok;
                                    }else{
                                        $modProduk->jml_now = 0;
                                        $modProduk->do_produk_status = 2;
                                    }
                                    
                                    //var_dump($modProduk->validate());die;
                                    $modProduk->save();
                                } else {
                                    $transaction->rollback();
                                    Yii::$app->session->setFlash('error', 'Data Penjualan tidak berhasil di simpan');
                                }
                        }
                    /* }else{
                        $transaction->rollback();
                        Yii::$app->session->setFlash('error', 'Error validasi Data tidak berhasil di simpan');
                    } */

                    $no++;
                }
                
                //check semua item rakitan sudah disave
                //var_dump((int) $countrak == (int) $no);die;
                if((int) $countrak == (int) $no){
                    
                    $modRakitan = RakitanT::findOne($model->rakitan);
                    $modRakitan->status = 'Soldout';
                    $modRakitan->penjualan = (int) $penjualan;

                    //var_dump($modRakitan->validate());die;
                    if($modRakitan->save()){
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                    }else{
                        $transaction->rollback();
                        Yii::$app->session->setFlash('error', 'Gagal update rakitan');
                    }
                }
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('warning', 'Error update barang rakitan -> ' . $ex);
                $transaction->rollback();
            }
            return $this->redirect(['update', 'penjualan' => $model->penjualan]);
            //return;
        } else {
            return $this->renderAjax('createprodukrakitan', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateprodukwo($penjualan)
    {
        $this->layout = 'kosong';
        $model = new WoProdukT();
        //$model->wo = $wo;
        
        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            //var_dump($model->wo);die;
            $modProdukwo = WoProdukT::find()->where(['wo' => (int) $model->wo])->asArray()->all();
            $countwo = WoProdukT::find()->where(['wo' => (int) $model->wo])->asArray()->count();
            $no = 0;
            $transaction = Yii::$app->db->beginTransaction();
            try {

                foreach($modProdukwo as $rowModProduk){
                    $imodel = new PenjualanProdukT();
                    $imodel->do_produk = (int) $rowModProduk['do_produk'];
                    $imodel->produk = (int) $rowModProduk['produk'];
                    $imodel->penjualan = (int) $penjualan;
                    $imodel->user_input  = Yii::$app->user->identity->id;
                    $imodel->penjualan_jml = (int) $rowModProduk['wo_jml'];
                    $imodel->penjualan_hpp =  round( (int) $rowModProduk['wo_hpp'], 0);
                    $imodel->penjualan_harga =  round( (int) $rowModProduk['wo_harga'], 0);
                    $modProduk = DoProdukT::findOne($rowModProduk['do_produk']);

                    //var_dump($imodel->validate());die;
                    if($imodel->validate()){
                        $check = PenjualanProdukT::find()->where(['penjualan' => $penjualan, 'produk' => $imodel->produk, 'penjualan_harga' => $imodel->penjualan_harga])->count();
                        if($check > 0){
                            $transaction->rollback();
                            Yii::$app->session->setFlash('warning', 'Produk sudah ada, update di produk tersebut, data tidak di simpan!');
                        }else{
        
                                if($imodel->save()) {

                                    $sisa_stok = $modProduk->jml_now - $imodel->penjualan_jml;
                                    if($sisa_stok > 0){
                                        $modProduk->jml_now = $sisa_stok;
                                    }else{
                                        $modProduk->jml_now = 0;
                                        $modProduk->do_produk_status = 2;
                                    }
                                    
                                    if($modProduk->save()){

                                    }else{
                                        $transaction->rollback();
                                        Yii::$app->session->setFlash('error', 'Data Produk tidak berhasil di simpan');
                                    }
                                } else {
                                    $transaction->rollback();
                                    Yii::$app->session->setFlash('error', 'Data Penjualan tidak berhasil di simpan');
                                }
                        }
                    }else{
                        $transaction->rollback();
                        Yii::$app->session->setFlash('error', 'Error validasi Data tidak berhasil di simpan');
                    }

                    $no++;
                }
                
                //check semua item rakitan sudah disave
                if((int) $countwo == (int) $no){
                    
                    $modWo = WoT::findOne($model->wo);
                    $modWo->status = 'Soldout';
                    $modWo->penjualan = (int) $penjualan;

                    //var_dump($modWo->validate());die;
                    if($modWo->save()){
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                    }else{
                        $transaction->rollback();
                        Yii::$app->session->setFlash('error', 'Gagal update rakitan');
                    }
                }
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('warning', 'Error update barang rakitan');
                $transaction->rollback();
            }
            return $this->redirect(['update', 'penjualan' => $penjualan]);
            //return;
        } else {
            return $this->renderAjax('createprodukwo', [
                'model' => $model,
            ]);
        }
    }


    public function actionUpdateproduk($penjualan_produk)
    {
        $this->layout = 'kosong';
        $model = PenjualanProdukT::findOne($penjualan_produk);
        $penjualan = $model->penjualan;
        $old_penjualan_jml = $model->penjualan_jml;

        //CURRENT
        $modProduk = DoProdukT::findOne($model->do_produk);
        //ORIGIN
        $do_produk_origin = $modProduk->do_produk_origin;
        //JIka current do_produk tidak ada stok
        if($do_produk_origin > 0 && $modProduk->jml_now == 0){
            //check origin du_produk asal jika ada
            $cmodProdukOrigin = DoProdukT::findOne($do_produk_origin);
            if($cmodProdukOrigin != null){
                $cstok_jml = $cmodProdukOrigin->jml_now;
            }else{
                $cstok_jml = 0;
            }
            if($cstok_jml > 0){
                //jika stok di origin masih
                $modProdukOrigin = $cmodProdukOrigin;
                $sebatch = true;
            }else{
                //jika stok di origin habis check barang setipe produk
                $checkother = DoProdukT::find()->where(['produk' => $model->produk])->andWhere('jml_now > 0')->asArray()->one();
                if($checkother != null){
                    $modProdukOrigin = DoProdukT::findOne($checkother['do_produk']);
                    $sebatch = false;
                }else{
                    $modProdukOrigin = null;
                    $sebatch = false;
                }
            }
            
        }else if($do_produk_origin == 0 && $modProduk->jml_now == 0){
            //jika tidak punya origin asal check barang setipe produk
            $checkother = DoProdukT::find()->where(['produk' => $model->produk])->andWhere('jml_now > 0')->asArray()->one();
            if($checkother != null){
                $modProdukOrigin = DoProdukT::findOne($checkother['do_produk']);
                $sebatch = false;
            }else{
                $modProdukOrigin = null;
                $sebatch = false;
            }
        }else{
            $modProdukOrigin = $modProduk;
            $sebatch = true;
        }

        $model->sebatch = $sebatch;
        
        //CURRENT
        $do_produk = $modProduk->do_produk;
        
        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);

            }

            if($model->validate()){
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if($model->sebatch == true){

                        if($modProdukOrigin->do_produk == $do_produk){
                        
                            if($model->save()) {

                                //check pengurangan atau penambahan produk
                                if($old_penjualan_jml > $model->penjualan_jml){
                                    $adj = $old_penjualan_jml - $model->penjualan_jml;
                                    $reduce = true;
                                }else{
                                    $adj = $model->penjualan_jml - $old_penjualan_jml;
                                    $reduce = false;
                                }

                                if($reduce == true){
                                    $sisa_stok = $modProdukOrigin->jml_now + $adj;
                                }else{
                                    $sisa_stok = $modProdukOrigin->jml_now - $adj;
                                }
                                
                                if($sisa_stok > 0){
                                    $modProdukOrigin->jml_now = $sisa_stok;
                                }else{
                                    $modProdukOrigin->jml_now = 0;
                                    $modProdukOrigin->do_produk_status = 2;
                                }
                                
                                if($modProduk->save()){
                                    $transaction->commit();
                                    Yii::$app->session->setFlash('success', 'Data berhasil di update!');
                                }else{
                                    $transaction->rollback();
                                    Yii::$app->session->setFlash('error', 'Data tidak berhasil di update');
                                }
                            } else {
                                $transaction->rollback();
                                Yii::$app->session->setFlash('error', 'Data tidak berhasil di update');
                            }

                        }else{
                            $penjualan_produk = new PenjualanProdukT();
                            //input bacth baru harus di adj dari jmlh sebelum update
                            $addmore = $model->penjualan_jml - $old_penjualan_jml;
                            //INPUT BASE ON DIFFRENT BATCH
                            $penjualan_produk->produk = $modProdukOrigin->produk;
                            $penjualan_produk->penjualan = (int) $penjualan;
                            $penjualan_produk->user_input  = Yii::$app->user->identity->id;
                            $penjualan_produk->penjualan_hpp =  round( (int) $modProdukOrigin->do_harga, 0);
                            $penjualan_produk->penjualan_harga =  round( (int) $model->penjualan_harga, 0);
                            $penjualan_produk->penjualan_jml =  (int) $addmore;
                            $penjualan_produk->do_produk =  (int) $modProdukOrigin->do_produk;
                        
                            //var_dump($penjualan_produk->validate());die;
                            if($penjualan_produk->save()) {

                                $sisa_stok = $modProdukOrigin->jml_now - $addmore;
                                if($sisa_stok > 0){
                                    $modProdukOrigin->jml_now = $sisa_stok;
                                }else{
                                    $modProdukOrigin->jml_now = 0;
                                    $modProdukOrigin->do_produk_status = 2;
                                }
                                
                                if($modProdukOrigin->save()){
                                    $transaction->commit();
                                    Yii::$app->session->setFlash('success', 'Data berhasil di update!');
                                }else{
                                    $transaction->rollback();
                                    Yii::$app->session->setFlash('error', 'Data tidak berhasil di update');
                                }
                            } else {
                                $transaction->rollback();
                                Yii::$app->session->setFlash('error', 'Data tidak berhasil di update');
                            }

                        }
                    }else{
                        if($model->save()) {
                            $transaction->commit();
                            Yii::$app->session->setFlash('success', 'Harga berhasil di update!');
                        } else {
                            $transaction->rollback();
                            Yii::$app->session->setFlash('error', 'Harga tidak berhasil di update');
                        }
                    }
                } catch (Exception $ex) {
                    Yii::$app->session->setFlash('warning', 'Error update barang rakitan');
                    $transaction->rollback();
                }
            }else{
                Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
            }
            
            return $this->redirect(['update', 'penjualan' => $model->penjualan]);
            //return;
        } else {
            return $this->renderAjax('updateproduk', [
                'model' => $model,
                'sebatch' => $sebatch,
                'modProdukOrigin' => $modProdukOrigin
            ]);
        }
    }

    public function actionCreateproduktt($penjualan)
    {
        $this->layout = 'kosong';
        $model = new PenjualanProdukTtT();
        $modPenjualan = PenjualanT::findOne($penjualan);

        $UpForm = new UploadForm();
        $model->penjualan = $penjualan;
        
        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);

            }
            

            $model->produk = (int) $model->produk;
            $model->penjualan = (int) $penjualan;
            $model->produk = (int) $model->produk;
            $model->do_jml = (int) $model->do_jml;
            $model->do_hpp = (int) $model->do_hpp;
            $model->do_harga = (int) $model->do_harga;
            //$model->penjualan_hpp = (int) $modProduk->do_harga;
            $model->user_input  = Yii::$app->user->identity->id;
            $model->tt_date = date('Y-m-d'); 

            $transaction = Yii::$app->db->beginTransaction();
            try {
                
            $checkDo = PenjualanProdukTtT::find()->where(['penjualan' => $penjualan])->asArray()->one();
            if($checkDo != null){
                $mDoProdukT = DoProdukT::find()->where(['do_produk' => (int) $checkDo['do_produk']])->asArray()->one(); 
                $modDo = DopT::findOne($mDoProdukT['do']); 
            }else{

                $modDo = new DopT();

                //faktur generate
                $year = date('Y');
                $checkmax = DopT::find()->where(["DATE_FORMAT(do_tgl,'%Y')" => $year])
                ->count();
                $faktur = 'DO' . date('Ymd') . sprintf("%04s", $checkmax + 1);
    
                $modDo->supplier = 20; 
                $modDo->do_tgl = date('Y-m-d'); 
                $modDo->supplier = 20; 
                $modDo->do_status = 'Lunas'; 
                $modDo->us = Yii::$app->user->identity->id; 
                $modDo->do_status = 'Lunas'; 
                $modDo->faktur = $faktur; 
                $modDo->no_sj = $modPenjualan->faktur; 
                $modDo->keterangan = $modPenjualan->keterangan; 
                $modDo->do_diskon = 0; 
            }
            //var_dump($modDo->validate());die;
            
                if($modDo->save()) {

                    $modProduk = new DoProdukT();
                    $modProduk->do = (int) $modDo->do;
                    $modProduk->stok_jenis = 1;
                    $modProduk->produk = (int) $model->produk;
                    $modProduk->do_jml = (int) $model->do_jml;
                    $modProduk->do_harga = (int) $model->do_hpp;
                    $modProduk->harga_jual = (int) $model->do_harga;
                    $modProduk->jml_now = (int) $model->do_jml;
                    $modProduk->do_produk_status = 1;
                    $modProduk->do_produk_date = date('Y-m-d'); 
                    $modProduk->do_produk_date_stok = date('Y-m-d'); 
                    $modProduk->inventori = (int) $model->inventori;
                    
                    
                    if($modProduk->save()){
                        

                        $modBayar = new AkunSaldoT();
            
                        if ($UpForm->load($this->request->post())) {
                                
                            //========================================================================//
                            //===========================IMAGE HANDLE=================================//
                            $UpForm->file = UploadedFile::getInstance($UpForm, 'file');

                            if ($UpForm->file && $UpForm->validate()) {  
                            //$bytes = random_bytes(3);
                            $ran = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,3);
                            $upload_dir = Yii::getAlias('@webroot') . '/uploads/doc_pemb/' . $modDo->faktur . '/';

                            if (!file_exists($upload_dir)) //Buat folder
                            //mkdir($upload_dir);
                            FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

                            //image
                            $img = $UpForm->file;
                            //get filesize
                            $file_size = $UpForm->file->size;
                            //set build directory
                            $url_database = Yii::$app->request->baseUrl . '/uploads/doc_pemb/' . $modDo->faktur . '/' . $modProduk->produk . '-' . $modProduk->do_produk  . '.' . $UpForm->file->extension;
                            $nama_foto = $modProduk->produk . '-' . $modProduk->do_produk . '.' . $UpForm->file->extension;

                            //save to directori 'uploads/doc_penj/'
                            $UpForm->file->saveAs($upload_dir . $nama_foto);
                            //set it to model
                            $modupimage = DoProdukT::findOne($modProduk->do_produk);
                            $modupimage->nama_foto = $nama_foto;
                            $modupimage->type = $UpForm->file->extension;
                            $modupimage->size = $file_size;
                            $modupimage->url = $url_database;
                            }
                            
                            $modupimage->save();

                            $modBayar->aktiva = 12;
                            $modBayar->akun = 2;
                            $modBayar->noref = (int) $modDo->do;
                            $modBayar->notrans = 'USERTT';
                            $modBayar->ket = 'USER TT ' . $modPenjualan->faktur;
                            $modBayar->jml = (int) $model->do_hpp;
                            $modBayar->datetime = date('Y-m-d H:i:s');
                            $modBayar->user = Yii::$app->user->identity->id;
                            $modBayar->nama_foto = $nama_foto;
                            $modBayar->type = $UpForm->file->extension;
                            $modBayar->size = $file_size;
                            $modBayar->url = $url_database;
                            //var_dump($modBayar->validate());die;
                            $modBayar->save();
                            //========================================================================//
                            //===========================IMAGE HANDLE=================================//
                        
                            $model->do_produk = (int) $modProduk->do_produk;
                            
                            if($model->save()){
                                $transaction->commit();
                                Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                            }else{
                                $transaction->rollback();
                                Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                            }
                        }else{
                            $transaction->rollback();
                            Yii::$app->session->setFlash('warning', 'Data tidak berhasil di simpan (tidak ada gambar)!');
                        }

                    }else{
                        $transaction->rollback();
                        Yii::$app->session->setFlash('error', 'Data Produk TT tidak berhasil di simpan');
                    }
                } else {
                    $transaction->rollback();
                    Yii::$app->session->setFlash('error', 'Data Pembelian tidak berhasil di simpan');
                }

            } catch (Exception $ex) {
                Yii::$app->session->setFlash('warning', 'Error input barang TT');
                $transaction->rollback();
            }
    
            return $this->redirect(['update', 'penjualan' => $model->penjualan]);
            //return;
        } else {
            return $this->renderAjax('createproduktt', [
                'model' => $model,
                'UpForm' => $UpForm
            ]);
        }
    }

    public function actionDeleteproduk($penjualan_produk)
    {
        $model = PenjualanProdukT::findOne($penjualan_produk);
        $penjualan = $model->penjualan;
        
        $modProduk = DoProdukT::findOne($model->do_produk);
        if($modProduk->jml_now > 0){
            $modProduk->jml_now = $modProduk->jml_now + $model->penjualan_jml;
        }else{
            $modProduk->jml_now = $model->penjualan_jml;
            $modProduk->do_produk_status = 1;
        }

        if($modProduk->save() && $model->delete()){
            Yii::$app->session->setFlash('success', 'Data berhasil di hapus!');
        }else{
            Yii::$app->session->setFlash('error', 'Data tidak berhasil dihapus');
        }
        return $this->redirect(['update', 'penjualan' => $model->penjualan]);
    }

    /**
     * Deletes an existing PenjualanT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $penjualan Penjualan
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($penjualan)
    {
        $model = $this->findModel($penjualan);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if($model->delete()){
                $transaction->commit();
                Yii::$app->session->setFlash('sucess', 'Data berhasil dihapus');
            }else{
                $transaction->rollback();
                Yii::$app->session->setFlash('warning', 'Data tidak hapus, hapus dulu semua item yang ada di penjualan!');
            }
        } catch (Exception $ex) {
            $transaction->rollback();
            Yii::$app->session->setFlash('warning', 'Data tidak hapus, hapus dulu semua item yang ada di penjualan!');
            //return $this->redirect(['index']);
        }

        return $this->redirect(['index']);
    }

    public function actionDelbayar($akun_saldo)
    {

        $model = AkunSaldoT::findOne($akun_saldo);

        $transaction = Yii::$app->db->beginTransaction();
        try {
                
                $modP = Penjualanv::findOne($model->noref);
                if( $modP->total_plus_ppn > 0 ){ $max = $modP->total_plus_ppn; } else { $max = 0; }
                //get total bayar jika ada
                if( $modP->total_bayar > 0 ){ $total_bayar =$modP->total_bayar; } else { $total_bayar = 0; }
                //kekurangan
                $kurang = $max - $total_bayar;
                
                $modPenj = PenjualanT::findOne($model->noref);
                if($kurang > 0){
                    $modPenj->penjualan_status = 'Piutang';
                }else{
                    $modPenj->penjualan_status = 'Lunas';
                }
                if($modPenj->save()){
                    if($model->delete()){
                        $transaction->commit();
                        Yii::$app->session->setFlash('sucess', 'Pembayaran berhasil dihapus');
                    }else{
                        $transaction->rollback();
                        Yii::$app->session->setFlash('warning', 'Pembayaran gagal dihapus');
                    }
                }else{
                    $transaction->rollback();
                    Yii::$app->session->setFlash('warning', 'Pembayaran gagal dihapus');
                }
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('warning', 'Error update barang rakitan');
            $transaction->rollback();
        }
        return $this->redirect(['update', 'penjualan' => $model->noref]);
    }

    /**
     * Finds the PenjualanT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $penjualan Penjualan
     * @return PenjualanT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($penjualan)
    {
        if (($model = PenjualanT::findOne(['penjualan' => $penjualan])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    // Print $penjualan output
    public function actionPrint($penjualan) {
        
        $model = PenjualanT::findOne($penjualan);
        $check = PenjualanProdukT::find()->where(['penjualan' => $penjualan])->count();
        
        if($check > 0){
            $this->layout = 'headerPrint';
            $model = PenjualanT::findOne($penjualan);
            $nama = VariableT::find()->where('nama="Nama"')->all();
            $alamat = VariableT::find()->where('nama="Alamat"')->all();
            $telp = VariableT::find()->where('nama="Telp"')->all();
            $Konsumen = KonsumenT::find()->where(['konsumen' => $model->konsumen])->all();
            $Sales = BackendUser::find()->where(['id' => $model->sales])->all();
            $PenjualanProduk = PenjualanProdukT::find()->where(['penjualan' => $penjualan]);
    
            Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                'format' => Pdf::FORMAT_A4,
                'destination' => Pdf::DEST_BROWSER,
                'filename' => $model->faktur,
                'content' => $this->renderPartial('print', [
                    'model' => $model,
                    'PenjualanProduk' => $PenjualanProduk,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'telp' => $telp,
                    'Konsumen' => $Konsumen,
                    'Sales' => $Sales
                ]),
                'cssFile' => '../web/css/kv-mpdf-bootstrap.min.css',
                'cssInline' => '<link media="print" rel="stylesheet" href="../web/css/app.css">
                #viewerContainer{fontsize:11px!important;}',
                'options' => [
                    // any mpdf options you wish to set
                    //'title' => 'No.PO: ' . $model->faktur,
                ],
                'methods' => [
                    'SetTitle' => 'Nota: ' . $model->faktur,
                    /* 'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy', */
                    /* 'SetHeader' => ['Dicetak dan di approve oleh: ' . Yii::$app->user->identity->nama . '||Tgl.cetak: ' . date("r")], */
                    /* 'SetFooter' => ['|Page {PAGENO}|'], */
                    'SetAuthor' => Yii::$app->user->identity->nama . 'PGRPN',
                    'SetCreator' => 'PGRPN',
                    'SetKeywords' => 'PGRPN, Export, PDF, MPDF, Output, Manifest',
                ]
            ]);
            return $pdf->render();
        }else{
            $this->layout = 'kosong';
            return $this->redirect(['update', 
                'penjualan' => $penjualan
            ]);

        }
    }
}

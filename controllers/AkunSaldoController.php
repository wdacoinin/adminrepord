<?php

namespace app\controllers;

use Yii;
use yii\widgets\ActiveForm;
use app\models\AkunSaldoT;
use app\models\AkunSaldo;
use app\models\BebanT;
use app\models\Dopembelianv;
use app\models\DoProdukT;
use app\models\DopT;
use app\models\PenjualanProdukTtT;
use app\models\PenjualanT;
use app\models\Penjualanv;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use Exception;
use Mpdf\Tag\Select;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * AkunSaldoController implements the CRUD actions for AkunSaldoT model.
 */
class AkunSaldoController extends Controller
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
     * Lists all AkunSaldoT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new AkunSaldo();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all AkunSaldoT models.
     *
     * @return string
     */
    public function actionTransaksi()
    {
        $this->layout = 'kosong';
        $searchModel = new AkunSaldo();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('_transaksi', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AkunSaldoT model.
     * @param int $akun_saldo Akun Saldo
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($akun_saldo)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($akun_saldo),
        ]);
    }

    /**
     * Creates a new AkunSaldoT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreatetransaksi()
    {
        $this->layout = 'kosong';
        $model = new AkunSaldoT();
        $model->aktiva= 13;
        $model->beban_jenis= 1;
        $UpForm = new UploadForm();

        $model->user = Yii::$app->user->identity->id;

        //get noref 0
        $model->noref = 0;
        $year = date('Y');
        //get LAST notrans on free transaksi
        $checkmax = AkunSaldoT::find()->where(["DATE_FORMAT(datetime,'%Y')" => $year, 'noref' => 0])
        ->count();
        $notrans = 'DRT' . date('Ymd') . sprintf("%04s", $checkmax + 1);
        //set noref to 0
        $model->noref = 0;
        $model->notrans = $notrans;
        //lock for free transaksi
        $from = 'Transaksi';


        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
                
                //========================================================================//
                //===========================IMAGE HANDLE=================================//
                $UpForm->file = UploadedFile::getInstance($UpForm, 'file');

                if ($UpForm->file && $UpForm->validate()) {  
                    //$bytes = random_bytes(3);
                    $ran = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,3);
                    $upload_dir = Yii::getAlias('@webroot') . '/uploads/transaksi/';
                    //var_dump($upload_dir);die;

                    if (!file_exists($upload_dir)) //Buat folder bername temp
                    //mkdir($upload_dir);
                    FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

                    //image
                    $img = $UpForm->file;
                    //get filesize
                    $file_size = $UpForm->file->size;
                    $url_database = Yii::$app->request->baseUrl . '/uploads/transaksi/' . $model->notrans . "-" . $ran . '.' . $UpForm->file->extension;
                    $nama_foto = $model->notrans . "-" . $ran . '.' . $UpForm->file->extension;

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
                    
            
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        if($model->save()) {
                            $transaction->commit();
                            Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                            return $this->redirect(['transaksi']);
                        } else {
                            $transaction->rollback();
                            Yii::$app->session->setFlash('error', 'Data File tidak berhasil di simpan');
                        }

                    } catch (Exception $ex) {
                        $transaction->rollback();
                        Yii::$app->session->setFlash('warning', 'Error update barang rakitan');
                    }
                    
                }else{
                    Yii::$app->session->setFlash('warning', 'Data tidak berhasil di simpan, bukti(gambar) kosong');
                    return $this->redirect(['transaksi']);
                }
            
        } else {
            return $this->renderAjax('createtransaksi', [
                'model' => $model,
                'from' => $from,
                'UpForm' => $UpForm,
            ]);
        }
    }

    /**
     * Creates a new AkunSaldoT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new AkunSaldoT();
        $UpForm = new UploadForm();

        $model->user = Yii::$app->user->identity->id;

        if(isset($_GET['do'])){
            //get noref
            $noref = $_GET['do'];
            //get nilai pembelian
            $modDo = Dopembelianv::findOne($noref);
            if( $modDo->total_plus_ppn > 0 ){ $max = $modDo->total_plus_ppn; } else { $max = 0; }
            //get total bayar jika ada
            if( $modDo->total_bayar > 0 ){ $total_bayar =$modDo->total_bayar; } else { $total_bayar = 0; }
            //kekurangan
            $kurang = $max - $total_bayar;
            $model->jml = $kurang;
            //noref to notrans value
            $model->noref = $noref;
            $model->notrans = $modDo->faktur;
            //lock for do
            $from = 'DO';

        }elseif(isset($_GET['penjualan'])){
            //get noref
            $noref = $_GET['penjualan'];
            //get nilai penjualan
            $modP = Penjualanv::findOne($noref);
            if( $modP->total_plus_ppn > 0 ){ $max = $modP->total_plus_ppn; } else { $max = 0; }
            //get total bayar jika ada
            if( $modP->total_bayar > 0 ){ $total_bayar =$modP->total_bayar; } else { $total_bayar = 0; }
            //kekurangan
            $kkurang = $max - $total_bayar;
            //get tt
            $modPenjTT = PenjualanProdukTtT::find()->select('SUM(do_jml*do_hpp) AS totaltt')->where(['penjualan' => $noref])->asArray()->one();
            if($modPenjTT != null){
                $totaltt = (int) $modPenjTT['totaltt'];
                $kurang = $kkurang - $totaltt;
            }else{
                $kurang = $kkurang;
            }
            $model->jml = $kurang;
            //noref to notrans value
            $model->noref = $noref;
            $model->notrans = $modP->faktur;
            //lock for do
            $from = 'MJP';
        }else{
            //get noref 0
            $model->noref = 0;
            $year = date('Y');
            //get LAST notrans on free transaksi
            $checkmax = AkunSaldoT::find()->where(["DATE_FORMAT(datetime,'%Y')" => $year, 'noref' => 0])
            ->count();
            $notrans = 'DRT' . date('Ymd') . sprintf("%04s", $checkmax + 1);
            //set noref to 0
            $model->noref = 0;
            $model->notrans = $notrans;
            //lock for free transaksi
            $from = 'Transaksi';
        }


        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
                
                //========================================================================//
                //===========================IMAGE HANDLE=================================//
                $UpForm->file = UploadedFile::getInstance($UpForm, 'file');

                if ($UpForm->file && $UpForm->validate()) {  
                    //$bytes = random_bytes(3);
                    $ran = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,3);
                    $upload_dir = Yii::getAlias('@webroot') . '/uploads/transaksi/';
                    //var_dump($upload_dir);die;

                    if (!file_exists($upload_dir)) //Buat folder bername temp
                    //mkdir($upload_dir);
                    FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

                    //image
                    $img = $UpForm->file;
                    //get filesize
                    $file_size = $UpForm->file->size;
                    $url_database = Yii::$app->request->baseUrl . '/uploads/transaksi/' . $model->notrans . "-" . $ran . '.' . $UpForm->file->extension;
                    $nama_foto = $model->notrans . "-" . $ran . '.' . $UpForm->file->extension;

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
                    
            
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        if($model->save()) {
                            //Yii::$app->session->setFlash('success', 'Data File berhasil di simpan!');
                            if($from == 'DO'){

                                $modDo = Dopembelianv::findOne($noref);
                                if( $modDo->total_plus_ppn > 0 ){ $max = $modDo->total_plus_ppn; } else { $max = 0; }
                                //get total bayar jika ada
                                if( $modDo->total_bayar > 0 ){ $total_bayar =$modDo->total_bayar; } else { $total_bayar = 0; }
                                //kekurangan
                                $kurang = $max - $total_bayar;

                                $modPembelian = DopT::findOne($noref);

                                if($kurang > 0){
                                    $modPembelian->do_status = 'Hutang';
                                }else{
                                    $modPembelian->do_status = 'Lunas';
                                }
                                if($modPembelian->save()){
                                    $transaction->commit();
                                    Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                                }else{
                                    $transaction->rollback();
                                    Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                                }
                                return $this->redirect(['dopembelian/update', 'do' => $noref]);
                            }elseif($from == 'MJP'){

                                    $modP = Penjualanv::findOne($noref);
                                    if( $modP->total_plus_ppn > 0 ){ $max = $modP->total_plus_ppn; } else { $max = 0; }
                                    //get total bayar jika ada
                                    if( $modP->total_bayar > 0 ){ $total_bayar =$modP->total_bayar; } else { $total_bayar = 0; }
                                    //kekurangan
                                    $kkurang = $max - $total_bayar;
                                    //get tt
                                    $modPenjTT = PenjualanProdukTtT::find()->select('SUM(do_jml*do_hpp) AS totaltt')->where(['penjualan' => $noref])->asArray()->one();
                                    if($modPenjTT != null){
                                        $totaltt = (int) $modPenjTT['totaltt'];
                                        $kurang = $kkurang - $totaltt;
                                    }else{
                                        $kurang = $kkurang;
                                    }

                                    $modPenj = PenjualanT::findOne($noref);
                                    //var_dump($kurang);die;
                                    if((int) $kurang > 0){
                                        $modPenj->penjualan_status = 'Piutang';
                                    }else{
                                        $modPenj->penjualan_status = 'Lunas';
                                    }
                                    if($modPenj->save()){
                                        $transaction->commit();
                                        Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                                    }else{
                                        $transaction->rollback();
                                        Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                                    }
                                    return $this->redirect(['penjualan/update', 'penjualan' => $noref]);
                            }else{
                                $transaction->commit();
                                Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                                return $this->redirect(['index']);
                            }
                        } else {
                            $transaction->rollback();
                            Yii::$app->session->setFlash('error', 'Data File tidak berhasil di simpan');
                        }

                    } catch (Exception $ex) {
                        $transaction->rollback();
                        Yii::$app->session->setFlash('warning', 'Error update barang rakitan');
                    }
                    
                }else{
                    if($from == 'DO'){
                        Yii::$app->session->setFlash('warning', 'Data tidak berhasil di simpan, bukti(gambar) kosong');
                        return $this->redirect(['dopembelian/update', 'do' => $noref]);
                    }elseif($from == 'MJP'){
                        Yii::$app->session->setFlash('warning', 'Data tidak berhasil di simpan, bukti(gambar) kosong');
                        return $this->redirect(['penjualan/update', 'penjualan' => $noref]);
                    }else{
                        Yii::$app->session->setFlash('warning', 'Data tidak berhasil di simpan, bukti(gambar) kosong');
                        return $this->redirect(['index']);
                    }
                }
            
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'from' => $from,
                'UpForm' => $UpForm,
            ]);
        }
    }

    /**
     * Updates an existing AkunSaldoT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $akun_saldo Akun Saldo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($akun_saldo)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($akun_saldo);
        $UpForm = new UploadForm();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            
            //========================================================================//
            //===========================IMAGE HANDLE=================================//
            $UpForm->file = UploadedFile::getInstance($UpForm, 'file');

            if ($UpForm->file && $UpForm->validate() && $model->size == 0) {  
                //$bytes = random_bytes(3);
                $ran = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,3);
                $upload_dir = Yii::getAlias('@webroot') . '/uploads/transaksi/';
                //var_dump($upload_dir);die;

                if (!file_exists($upload_dir)) //Buat folder bername temp
                //mkdir($upload_dir);
                FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

                //image
                $img = $UpForm->file;
                //get filesize
                $file_size = $UpForm->file->size;
                $url_database = Yii::$app->request->baseUrl . '/uploads/transaksi/' . $model->notrans . "-" . $ran . '.' . $UpForm->file->extension;
                $nama_foto = $model->notrans . "-" . $ran . '.' . $UpForm->file->extension;

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
                    Yii::$app->session->setFlash('success', 'Data berhasil update!');
                } else {
                    Yii::$app->session->setFlash('error', 'Data tidak berhasil di update');
                }
            }elseif(!$UpForm->file && $model->size == 0){
                Yii::$app->session->setFlash('warning', 'Data tidak berhasil di update, Bukti Gambar kosong!');
            }elseif($UpForm->file && $model->size > 0){
                Yii::$app->session->setFlash('error', 'Data tidak berhasil di update, hapus dulu gambar lama!');
            }else{
                if($model->save()) {
                    Yii::$app->session->setFlash('success', 'Data berhasil update!');
                } else {
                    Yii::$app->session->setFlash('error', 'Data tidak berhasil di update');
                }
            }
            return $this->redirect(['transaksi']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'UpForm' => $UpForm,
            ]);
        }
    }

    public function actionSbeban()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->layout = 'api';
        $prop = $_POST['depdrop_parents'];
        $beban_jenis =$prop[0];

        //var_dump($day);die;
        $beban = BebanT::find()->select('beban, nama')
        ->where(['beban_jenis' => $beban_jenis])
        ->asArray()->all();

        $dt=[];
        $selected='';
        if($beban != null){

            $data=[];
            foreach($beban as $row){
                $data[] = array(
                    'id' => $row['beban'],
                    'name' => $row['nama'],
                );
                //$selected = $data;
            } 
            $dt = $data;
            
            //return $data;
        }
        return ['output'=> $dt, 'selected'=>''];
    }

    /** $id_img, $akun_saldo
     * @return mixed 
     */
    public function actionDeletefile()
    {
        $file_key = (int)\Yii::$app->request->post('key');

        echo json_encode($file_key);
        
        $AkunSaldoT = AkunSaldoT::findOne($file_key);

        $exp = explode('/',$AkunSaldoT->url,3);
        
        $upload_dir = Yii::getAlias('@webroot') . '/' . $exp[2];
        
        $AkunSaldoT->nama_foto = '';
        $AkunSaldoT->type = '';
        $AkunSaldoT->size = '';
        $AkunSaldoT->url = '';
        if($AkunSaldoT->save()){
            unlink($upload_dir);
        }
        
    }

    /**
     * Deletes an existing AkunSaldoT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $akun_saldo Akun Saldo
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($akun_saldo)
    {
        $this->findModel($akun_saldo)->delete();

        return $this->redirect(['transaksi']);
    }

    /**
     * Finds the AkunSaldoT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $akun_saldo Akun Saldo
     * @return AkunSaldoT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($akun_saldo)
    {
        if (($model = AkunSaldoT::findOne(['akun_saldo' => $akun_saldo])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

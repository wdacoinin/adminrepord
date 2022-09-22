<?php

namespace app\controllers;

use Yii;
use yii\widgets\ActiveForm;
use app\models\Dopembelianv;
use app\models\Dopembelian;
use app\models\DopT;
use app\models\DoProduk;
use app\models\DoProdukT;
use app\models\ProdukT;
use app\models\AkunSaldo;
use app\models\AkunSaldoDo;
use app\models\AkunSaldoT;
use app\models\DocPembT;
use app\models\DoProdukOnNota;
use app\models\VariableT;
use PHPUnit\Framework\Constraint\ExceptionMessage;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * DopembelianController implements the CRUD actions for Dopembelianv model.
 */
class DopembelianController extends Controller
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
     * Lists all Dopembelianv models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Dopembelian();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dopembelianv model.
     * @param int $do Do
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($do)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($do),
        ]);
    }

    /**
     * Creates a new Dopembelianv model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new Dopembelianv();
        $model->do_diskon = 0;

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            //set default ppn if null or 0
            if($model->ppn > 0){
                $ppnv = VariableT::find()->select('val')->where('variable = 4')->one();
                $model->ppn = $ppnv['val'];
            }else{
                $model->ppn = 0;
            }
            
            $check = Dopembelianv::find()->where(['nama' => $model->divisi])->count();
            if($check > 0){
                Yii::$app->session->setFlash('warning', 'Nama sudah ada, data tidak di simpan!');
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
     * Updates an existing DopT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $do Do
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($do)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($do);
        $modTotal = Dopembelianv::findOne($do);
        $searchModel2 = new DoProdukOnNota();
        $dataProvider2 = $searchModel2->search($this->request->queryParams, $do);
        $searchModel3 = new AkunSaldoDo();
        $dataProvider3 = $searchModel3->search($this->request->queryParams, 12, $do);
        $DoProduk = DoProdukT::find()->where(['do' => $do]);
        $DocPemb = new DocPembT();

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            //set default ppn if null or 0
            if($model->ppn > 0){
                $ppnv = VariableT::find()->select('val')->where('variable = 4')->one();
                $model->ppn = $ppnv['val'];
            }else{
                $model->ppn = 0;
            }

            if($model->save()) {
                Yii::$app->session->setFlash('success', 'Data berhasil update!');
            } else {
                Yii::$app->session->setFlash('error', 'Data tidak berhasil di update');
            }
            return $this->redirect(['update', 'do' => $model->do]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modTotal' => $modTotal,
                'DoProduk' => $DoProduk,
                'DocPemb' => $DocPemb,
                'searchModel2' => $searchModel2,
                'dataProvider2' => $dataProvider2,
                'searchModel3' => $searchModel3,
                'dataProvider3' => $dataProvider3,
            ]);
        }
    }

    
    public function actionUpload($do)
    {
        $this->layout = 'kosong';
        $modDo = DopT::findOne($do);
        $DocPemb =new DocPembT();
        $UpForm = new UploadForm();
        $DocPemb->do = (int) $do;

        //validation
        if ($DocPemb->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($DocPemb);
            }

            $DocPemb->do = (int) $do;
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
                    $url_database = Yii::$app->request->baseUrl . '/uploads/doc_pemb/' . $modDo->faktur . '/' . $UpForm->file->name . '.' . $UpForm->file->extension;
                    $nama_foto = $UpForm->file->name . '.' . $UpForm->file->extension;

                    //save to directori 'uploads/doc_penj/'
                    $UpForm->file->saveAs($upload_dir . $nama_foto);
                    //set it to model
                    $DocPemb->doc = 'Nota';
                    $DocPemb->nama_foto = $UpForm->file->name;
                    $DocPemb->type = $UpForm->file->extension;
                    $DocPemb->size = $file_size;
                    $DocPemb->url = $url_database;
                    }
                    //var_dump($DocPemb->attributes);die;
                    //========================================================================//
                    //===========================IMAGE HANDLE=================================//
                    if($DocPemb->save()) {
                        Yii::$app->session->setFlash('success', 'File berhasil disimpan!');
                    } else {
                        Yii::$app->session->setFlash('danger', 'File tidak berhasil di input');
                    }
            }
            //return $this->redirect(Url::to(['tracking-order/index']));
            return $this->redirect(['update', 'do' => $modDo->do]);
        } else {
            return $this->renderAjax('upload', [
                'modDo' => $modDo,
                'DocPemb' => $DocPemb,
                'UpForm' => $UpForm,
            ]);
        }
    }


    public function actionDisplayFile($do)
    {
        $this->layout = 'kosong';
        $Do = DopT::findOne($do);
        $DoProduk = DoProdukT::find()->where(['penjualan' => $Do->do]);
        $DocPemb = new DocPembT();

        return $this->renderAjax('_displayFile', [
            'DocPemb' => $DocPemb,
            'DoProduk' => $DoProduk
        ]);
    }

    
    /** $id_img, $penjualan
     * @return mixed 
     */
    public function actionDeletenota()
    {
        $file_key = (int)\Yii::$app->request->post('key');

        echo json_encode($file_key);
        
        $DocPembT = DocPembT::findOne($file_key);

        $exp = explode('/',$DocPembT->url,3);
        
        $upload_dir = Yii::getAlias('@webroot') . '/' . $exp[2];
            
        if(unlink($upload_dir)){
            $DocPembT->delete();
        }

    }

    public function actionSmerek()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->layout = 'api';
        $prop = $_POST['depdrop_parents'];
        $kategori =$prop[0];
        if (isset($_POST['depdrop_params']) && !empty($_POST['depdrop_params'])) {
            $params = $_POST['depdrop_params'];
            $produk = $params[0];
            $merek = ProdukT::find()->select('produk.merek, merek.nama')
            ->join("LEFT JOIN", "merek", "produk.merek=merek.merek")
            ->where(['kategori' => $kategori, 'produk' => $produk])
            ->groupBy('produk.merek')
            ->asArray()->all();
        }else{
            $merek = ProdukT::find()->select('produk.merek, merek.nama')
            ->join("LEFT JOIN", "merek", "produk.merek=merek.merek")
            ->where(['kategori' => $kategori])
            ->groupBy('produk.merek')
            ->asArray()->all();
        }

        //var_dump($day);die;

        $dt=[];
        $selected='';
        if($merek != null){

            $data=[];
            foreach($merek as $row){
                $data[] = array(
                    'id' => $row['merek'],
                    'name' => $row['nama'],
                );
                $selected = $data;
            } 
            $dt = $data;
            
            //return $data;
        }
        return ['output'=> $dt, 'selected'=>$selected];
    }

    public function actionSproduk()
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
        $produk = ProdukT::find()->select('produk, nama')
        ->where(['kategori' => $kategori, 'merek' => $merek])
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


    /**
     * Creates a new DoProdukT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreateproduk($do)
    {
        $this->layout = 'kosong';
        $model = new DoProdukT();
        $modDo = DopT::findOne($do);
        $UpForm = new UploadForm();
        $model->do = $do;
        
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
                    $upload_dir = Yii::getAlias('@webroot') . '/uploads/doc_pemb/' . $modDo->faktur . '/';

                    if (!file_exists($upload_dir)) //Buat folder
                    //mkdir($upload_dir);
                    FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

                    //image
                    $img = $UpForm->file;
                    //get filesize
                    $file_size = $UpForm->file->size;
                    //set build directory
                    $url_database = Yii::$app->request->baseUrl . '/uploads/doc_pemb/' . $modDo->faktur . '/' . $model->produk . '-' . $ran  . '.' . $UpForm->file->extension;
                    $nama_foto = $model->produk . '-' . $ran . '.' . $UpForm->file->extension;

                    //save to directori 'uploads/doc_penj/'
                    $UpForm->file->saveAs($upload_dir . $nama_foto);
                    //set it to model
                    $model->nama_foto = $nama_foto;
                    $model->type = $UpForm->file->extension;
                    $model->size = $file_size;
                    $model->url = $url_database;
                
                    if($model->validate()){
                        $check = DoProdukT::find()->where(['do' => $do, 'produk' => $model->produk, 'do_harga' => $model->do_harga, 'stok_jenis' => $model->stok_jenis])->count();
                        if($check > 0){
                            Yii::$app->session->setFlash('warning', 'Nama sudah ada, update di produk tersebut, data tidak di simpan!');
                        }else{
                            $model->jml_now = $model->do_jml;
                            if($model->save()) {
                                Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                            } else {
                                Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                            }
                        }
                    }else{
                        Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                    }
                }else{
                    Yii::$app->session->setFlash('warning', 'Data tidak berhasil di simpan, (gambar) kosong');
                }
                //var_dump($DocPemb->attributes);die;
                //========================================================================//
                //===========================IMAGE HANDLE=================================//
            }
            
            return $this->redirect(['update', 'do' => $model->do]);
            //return;
        } else {
            return $this->renderAjax('createproduk', [
                'model' => $model,
                'UpForm' => $UpForm,
            ]);
        }
    }

    /**
     * Updates an existing DoProdukT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $do_produk Do Produk
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateproduk($do_produk)
    {
        $this->layout = 'kosong';
        $UpForm = new UploadForm();
        /* $model = DoProdukT::find()
        ->where(['do_produk' => $do_produk])
        ->join("LEFT JOIN", "merek", "do_produk.merek=merek.merek")
        ->join("LEFT JOIN", "kategori", "do_produk.kategori=kategori.kategori")
        ->one(); */
        $model = DoProdukT::findOne($do_produk);
        $modDo = DopT::findOne($model->do);
        $model->produk0->kategori;
        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if($model->size > 0){
                if($model->save()) {
                    Yii::$app->session->setFlash('success', 'Data berhasil update!');
                } else {
                    Yii::$app->session->setFlash('error', 'Data tidak berhasil di update');
                }
            }else{

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
                    $url_database = Yii::$app->request->baseUrl . '/uploads/doc_pemb/' . $modDo->faktur . '/' . $model->produk . '-' . $model->do_produk . '.' . $UpForm->file->extension;
                    $nama_foto = $model->produk . '-' . $model->do_produk . '.' . $UpForm->file->extension;
    
                    //save to directori 'uploads/doc_penj/'
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
                        Yii::$app->session->setFlash('warning', 'Data tidak berhasil di simpan, (gambar) kosong');
                    }
                    //var_dump($DocPemb->attributes);die;
                    //========================================================================//
                    //===========================IMAGE HANDLE=================================//
                }
            }
            return $this->redirect(['update', 'do' => $model->do]);
        } else {
            return $this->renderAjax('updateproduk', [
                'model' => $model,
                'UpForm' => $UpForm,
            ]);
        }
    }

    /** $id_img, $penjualan
     * @return mixed 
     */
    public function actionDeletefileproduk()
    {
        $file_key = (int)\Yii::$app->request->post('key');

        echo json_encode($file_key);
        
        $DoProduk = DoProdukT::findOne($file_key);

        $exp = explode('/',$DoProduk->url,3);
        //var_dump($exp);die;
        
        $upload_dir = Yii::getAlias('@webroot') . '/' . $exp[2];

            
        if(unlink($upload_dir)){
            $DoProduk->nama_foto = '';
            $DoProduk->type = '';
            $DoProduk->size = '';
            $DoProduk->url = '';
            $DoProduk->save();
        }

    }

    /**
     * Deletes an existing Dopembelianv model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $do Do
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteproduk($do_produk)
    {
        $model = DoProdukT::findOne($do_produk);
        //$transaction = Yii::$app->db->beginTransaction();
        //try {
            if($model->delete()){
                Yii::$app->session->setFlash('sucess', 'Data berhasil dihapus');
            }else{
                Yii::$app->session->setFlash('warning', 'Data tidak hapus, hapus dulu semua item yang ada di pembelian');
            }
        //} catch (Exception $ex) {
            /* Yii::$app->session->setFlash('warning', 'Data tidak hapus, hapus dulu semua item yang ada di pembelian');
            $transaction->rollback(); */
        //}

        return $this->redirect(['dopembelian/update', 'do' => $model->do]);
        //return $this->redirect(['index']);
    }

    public function actionDelbayar($akun_saldo)
    {

        $model = AkunSaldoT::findOne($akun_saldo);

        $transaction = Yii::$app->db->beginTransaction();
        try {

            $modDo = Dopembelianv::findOne($model->noref);
            if( $modDo->total_plus_ppn > 0 ){ $max = $modDo->total_plus_ppn; } else { $max = 0; }
            //get total bayar jika ada
            if( $modDo->total_bayar > 0 ){ $total_bayar =$modDo->total_bayar; } else { $total_bayar = 0; }
            //kekurangan
            $kurang = $max - $total_bayar;

            $modPembelian = DopT::findOne($model->noref);

            if($kurang > 0){
                $modPembelian->do_status = 'Hutang';
            }else{
                $modPembelian->do_status = 'Lunas';
            }
            if($modPembelian->save()){
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

        return $this->redirect(['update', 'do' => $model->noref]);
    }

    /**
     * Deletes an existing Dopembelianv model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $do Do
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $do = $id;
        $model = $this->findModel($do);
        //$transaction = Yii::$app->db->beginTransaction();
        try {
            if($model->delete()){
                Yii::$app->session->setFlash('sucess', 'Data berhasil dihapus');
            }else{
                Yii::$app->session->setFlash('warning', 'Data tidak hapus, hapus dulu semua item yang ada di pembelian');
            }
        } catch (Exception $ex) {
            //$transaction->rollback();
            Yii::$app->session->setFlash('warning', 'Data tidak hapus, hapus dulu semua item yang ada di pembelian');
            return $this->redirect(['index']);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dopembelianv model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $do Do
     * @return DopT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($do)
    {
        if (($model = DopT::findOne(['do' => $do])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

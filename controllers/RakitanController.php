<?php

namespace app\controllers;

use app\models\DoProdukT;
use app\models\InventoriT;
use app\models\PenjualanProdukT;
use app\models\ProdukT;
use Yii;
use yii\widgets\ActiveForm;
use app\models\RakitanT;
use app\models\Rakitan;
use app\models\Rakitans;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use Exception;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * RakitanController implements the CRUD actions for RakitanT model.
 */
class RakitanController extends Controller
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
     * Lists all RakitanT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Rakitan();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRakitansold()
    {
        $this->layout = 'kosong';
        $searchModel = new Rakitans();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('indexsold', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RakitanT model.
     * @param int $rakitan Rakitan
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($rakitan)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($rakitan),
        ]);
    }

    /**
     * Creates a new RakitanT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new RakitanT();
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
                    $upload_dir = Yii::getAlias('@webroot') . '/uploads/rakitan/';
                    //var_dump($upload_dir);die;

                    if (!file_exists($upload_dir)) //Buat folder bername temp
                    //mkdir($upload_dir);
                    FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

                    //image
                    $img = $UpForm->file;
                    //get filesize
                    $file_size = $UpForm->file->size;
                    $url_database = Yii::$app->request->baseUrl . '/uploads/rakitan/' . $model->rakitan . "-" . $ran . '.' . $UpForm->file->extension;
                    $nama_foto = $model->rakitan . "-" . $ran . '.' . $UpForm->file->extension;

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
            $model->status = 'Ready';
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
     * Updates an existing RakitanT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $rakitan Rakitan
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($rakitan)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($rakitan);

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    
    public function actionBataljual($rakitan)
    {
        $model = $this->findModel($rakitan);
        $penjualan = $model->penjualan;
        $modProduk = DoProdukT::find()->where(['rakitan' => $rakitan])->asArray()->all();

        $countrak = DoProdukT::find()->where(['rakitan' => $model->rakitan])->asArray()->count();
        $no = 0;
        //var_dump($modProdukRakitan);die;
        $transaction = Yii::$app->db->beginTransaction();
        try {

            foreach($modProduk as $rowModProduk){


                $modProduk = DoProdukT::findOne($rowModProduk['do_produk']);
                $modProduk->jml_now = $modProduk->do_jml;
                $modProduk->do_produk_status = 1;
                
                if($modProduk->save()){
                    $modPenjProduk = PenjualanProdukT::find()->where(['penjualan' => $penjualan, 'do_produk' => $rowModProduk['do_produk']])->one();
                    if($modPenjProduk != null){
                        $modPenjProduk->delete();
                    }
                }else{
                    $transaction->rollback();
                    Yii::$app->session->setFlash('error', 'Data Produk tidak berhasil di simpan');
                }
                $no++;
            }
            
            //check semua item rakitan sudah disave
            if((int) $countrak == (int) $no){
                
                $modRakitan = RakitanT::findOne($model->rakitan);
                $modRakitan->status = 'Ready';
                $modRakitan->penjualan = NULL;

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
            Yii::$app->session->setFlash('warning', 'Error update barang rakitan');
            $transaction->rollback();
        }
        return $this->redirect(['update', 'rakitan' => $rakitan]);
    }

    public function actionOut($do_produk)
    {
        $this->layout = 'kosong';
        $model = DoProdukT::findOne($do_produk);
        $inventori = $model->inventori;
        $rakitan = $model->rakitan;
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }     
            //jika inventori berubah
            if($model->inventori != ''){
                $model->rakitan = NULL;

                if($model->save()){
                    Yii::$app->session->setFlash('success', 'Berhasil out barang di rakitan');
                }else{
                    Yii::$app->session->setFlash('warning', 'Gagal out barang di rakitan');
                }
            }else{
                $model->inventori = $inventori;
                $model->rakitan = $rakitan;
                if($model->save()){
                    Yii::$app->session->setFlash('success', 'Berhasil update barang di rakitan');
                }else{
                    Yii::$app->session->setFlash('warning', 'Gagal update barang di rakitan');
                }
            }

            return $this->redirect(['update',
                'rakitan' => $rakitan,
            ]);
        } else {
            //var_dump($model->rakitan);die;
            return $this->renderAjax('_formupdaterakitan', [
                'model' => $model,
            ]);
        }
    }

    public function actionInputproduk($rakitan)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($rakitan);

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }        
            
            if(!empty($model->do_produk)) {
                
                $produk = DoProdukT::findOne($model->do_produk);
                if((int) $model->jml_rakit <= (int) $produk->jml_now){

                    ///
                    $transaction = Yii::$app->db->beginTransaction();
                    try {

                            $split = new DoProdukT();
                            $split->do = $produk->do;
                            $split->produk = $produk->produk;
                            $split->stok_jenis = $produk->stok_jenis;
                            $split->do_jml = (int) $model->jml_rakit;
                            $split->jml_now = (int) $model->jml_rakit;
                            $split->do_harga = $produk->do_harga;
                            $split->harga_jual = $model->harga_jual;
                            $split->do_produk_status = $produk->do_produk_status;
                            $split->do_produk_date = $produk->do_produk_date;
                            $split->timestamp = date('Y-m-d H:m:i');
                            $split->do_produk_origin = $produk->do_produk;
                            $split->inventori = $model->inventori;
                            $split->rakitan = $model->rakitan;

                            if($split->save()){
                        
                                $jml_now = (int) $produk->jml_now - (int) $model->jml_rakit;
                                $produk->jml_now = (int) $jml_now;
                                if($produk->save()){

                                    $transaction->commit();
                                    Yii::$app->session->setFlash('success', 'Success update barang rakitan');

                                }else{
                                    Yii::$app->session->setFlash('warning', 'Gagal update barang do');
                                    $transaction->rollback();
                                }
                            }else{
                                Yii::$app->session->setFlash('warning', 'Gagal update barang di rakitan');
                                $transaction->rollback();
                            }
                    } catch (Exception $ex) {
                        Yii::$app->session->setFlash('warning', 'Error update barang rakitan');
                        $transaction->rollback();
                    }

                    Yii::$app->session->setFlash('success', 'Data berhasil update!');
                }else{
                    Yii::$app->session->setFlash('warning', 'Error update barang rakitan');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Data tidak berhasil di update');
            }
                                
            return $this->redirect(['update',
                'rakitan' => $rakitan,
            ]);
        } else {
            return $this->renderAjax('_forminputrakitan', [
                'model' => $model,
            ]);
        }
    }

    public function actionSmerek()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->layout = 'api';
        $prop = $_POST['depdrop_parents'];
        $id =$prop[0];

        //var_dump($day);die;
        $merek = ProdukT::find()->select(["
        produk.merek, 
        CASE WHEN COUNT(do_produk.do_produk) > 0 AND do_produk.do_produk_status = 1 THEN
        CONCAT(merek.nama, ' stok:', SUM(do_produk.jml_now))
        ELSE
        merek.nama
        END AS nama
        "])
        ->join("LEFT JOIN", "merek", "produk.merek=merek.merek")
        ->join("LEFT JOIN", "do_produk", "do_produk.produk=produk.produk")
        ->where(['produk.kategori' => $id])
        ->groupBy('produk.merek')
        ->distinct('produk.merek')
        ->asArray()->all();

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
            
        }
        return ['output'=> $dt, 'selected'=>$selected];
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
        $produk = ProdukT::find()->select(["
        produk.produk, 
        CASE WHEN COUNT(do_produk.do_produk) > 0 AND do_produk.do_produk_status = 1 THEN
        CONCAT(produk.nama, ' stok:', SUM(do_produk.jml_now))
        ELSE
        produk.nama
        END AS nama
        "])
        ->join("LEFT JOIN", "do_produk", "do_produk.produk=produk.produk")
        ->where(['kategori' => $kategori, 'merek' => $merek])
        ->groupBy('produk.produk')
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
        return ['output'=> $dt, 'selected'=>$selected];
    }


    public function actionSproduk()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->layout = 'api';
        $prop = $_POST['depdrop_parents'];
        $produk =$prop[0];

        //var_dump($day);die;
        $produk = DoProdukT::find()->select(["
        do_produk.do_produk, 
        CASE WHEN do_produk.do_produk_origin > 0 THEN
        CONCAT(do.faktur, '-', produk.produk, '-', do_produk.do_produk_origin, ', Qty: ', do_produk.jml_now, ', Lokasi: ', inventori.kode)
        ELSE
        CONCAT(do.faktur, '-', produk.produk, '-', do_produk.do_produk, ', Qty: ', do_produk.jml_now, ', Lokasi: ', inventori.kode)
        END AS nama
        "])
        ->where(['do_produk.produk' => $produk])
        ->andWhere('do_produk.jml_now > 0 AND do_produk.do_produk_status = 1 AND do_produk.rakitan IS NULL AND inventori.lokasi > 1')
        ->join("LEFT JOIN", "produk", "do_produk.produk=produk.produk")
        ->join("LEFT JOIN", "do", "do_produk.do=do.do")
        ->join("LEFT JOIN", "inventori", "do_produk.inventori=inventori.inventori")
        ->groupBy('do_produk.do_produk')
        ->asArray()->all();

        $dt=[];
        $selected='';
        if($produk != null){

            $data=[];
            foreach($produk as $row){
                $data[] = array(
                    'id' => $row['do_produk'],
                    'name' => $row['nama'],
                );
                //$selected = $data;
            } 
            $dt = $data;
            
            //return $data;
        }
        return ['output'=> $dt, 'selected'=>$selected];
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

    /**
     * Updates an existing RakitanT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $rakitan Rakitan
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdategambar($rakitan)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($rakitan);
        $UpForm = new UploadForm();
        $UpForm->file = $model->url;

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
                    $upload_dir = Yii::getAlias('@webroot') . '/uploads/rakitan/';
                    //var_dump($upload_dir);die;

                    if (!file_exists($upload_dir)) //Buat folder bername temp
                    //mkdir($upload_dir);
                    FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

                    //image
                    $img = $UpForm->file;
                    //get filesize
                    $file_size = $UpForm->file->size;
                    $url_database = Yii::$app->request->baseUrl . '/uploads/rakitan/' . $model->inventori0->kode .'-'.  $model->rakitan . '-' . $ran . '.' . $UpForm->file->extension;
                    $nama_foto = $model->inventori0->kode .'-'.  $model->rakitan . "-" . $ran . '.' . $UpForm->file->extension;

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
            
            if($model->save()) {
                Yii::$app->session->setFlash('success', 'Data berhasil update!');
            } else {
                Yii::$app->session->setFlash('error', 'Data tidak berhasil di update');
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
        
        $RakitanT = RakitanT::findOne($file_key);

        $exp = explode('/',$RakitanT->url,3);
        
        $upload_dir = Yii::getAlias('@webroot') . '/' . $exp[2];
        
        $RakitanT->nama_foto = '';
        $RakitanT->type = '';
        $RakitanT->size = '';
        $RakitanT->url = '';
        if($RakitanT->save()){
            unlink($upload_dir);
        }
        
    }


    /**
     * Deletes an existing RakitanT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $rakitan Rakitan
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($rakitan)
    {
        $model = $this->findModel($rakitan);
        try {
            if($model->delete()){
                Yii::$app->session->setFlash('sucess', 'Data berhasil dihapus');
            }else{
                Yii::$app->session->setFlash('warning', 'Data tidak hapus, hapus dulu semua item yang ada di rakitan');
            }
        } catch (Exception $ex) {
            //$transaction->rollback();
            Yii::$app->session->setFlash('warning', 'Data tidak hapus, hapus dulu semua item yang ada di rakitan');
            return $this->redirect(['index']);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the RakitanT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $rakitan Rakitan
     * @return RakitanT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($rakitan)
    {
        if (($model = RakitanT::findOne(['rakitan' => $rakitan])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

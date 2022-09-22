<?php

namespace app\controllers;

use app\models\DoProdukT;
use app\models\KonsumenT;
use app\models\PenjualanProdukT;
use Yii;
use yii\widgets\ActiveForm;
use app\models\WoT;
use app\models\Wo;
use app\models\WoProdukT;
use Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WoController implements the CRUD actions for WoT model.
 */
class WoController extends Controller
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
     * Lists all WoT models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'kosong';
        $searchModel = new Wo();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WoT model.
     * @param int $wo Wo
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($wo)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($wo),
        ]);
    }

    /**
     * Creates a new WoT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'kosong';
        $model = new WoT();

        //validation
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
                        Yii::$app->session->setFlash('success', 'Berhasil simpan Wo');
                    }else{
                        Yii::$app->session->setFlash('warning', 'Gagal simpan Wo');
                    }
                }else{
                    Yii::$app->session->setFlash('warning', 'Gagal simpan Wo');
                }
            }else{
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Berhasil simpan Wo');
                }else{
                    Yii::$app->session->setFlash('warning', 'Gagal simpan Wo');
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
     * Updates an existing WoT model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $wo Wo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($wo)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($wo);

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionPasang()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->layout = 'api';
        $wo_produk = $_POST['wo_produk'];
        $produk = WoProdukT::findOne($wo_produk);
        $produk->wo_produk_status = 'Terpasang';
        if($produk->save()){
            $data = array(
                'hasil' => 'success',
            );
        }else{
            $data = array(
                'hasil' => 'gagal',
            );
        }
        
        return $data;
    }

    public function actionInputproduk($wo)
    {
        $this->layout = 'kosong';
        //$model = $this->findModel($wo);
        $model = new WoProdukT;

        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }        
            
            if(!empty($model->do_produk)) {

                
                $produk = DoProdukT::findOne((int) $model->do_produk);
                if((int) $model->wo_jml <= (int) $produk->jml_now){
                    $jml_now = (int) $produk->jml_now - (int) $model->wo_jml;

                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        
                        if($jml_now > 0){
                            $produk->jml_now = $jml_now;
                            if($produk->save()){
                                $split = new DoProdukT();
                                $split->do = $produk->do;
                                $split->produk = $produk->produk;
                                $split->stok_jenis = $produk->stok_jenis;
                                $split->do_jml = (int) $model->wo_jml;
                                $split->jml_now = (int) $model->wo_jml;
                                $split->do_harga = (int) $produk->do_harga;
                                $split->harga_jual = (int) $model->wo_harga;
                                $split->do_produk_status = 4;
                                $split->do_produk_date = $produk->do_produk_date;
                                $split->timestamp = date('Y-m-d H:m:i');
                                $split->do_produk_origin = (int) $produk->do_produk;
                                $split->inventori = (int) $produk->inventori;
                                //$split->rakitan = $model->rakitan;
                
                                //var_dump($split->validate());die;
    
                                if($split->save()){
                                    $model->wo = (int) $wo;
                                    $model->produk = (int) $produk->produk;
                                    $model->do_produk = (int) $split->do_produk;
                                    $model->wo_hpp = (int) $produk->do_harga;
                                    $model->wo_produk_status = 'Ok';
                                    $model->wo_jml = (int) $model->wo_jml;
                                    $model->wo_harga = (int) $model->wo_harga;
                                    $model->user_input = Yii::$app->user->identity->id;
                                    
                                    if($model->save()){
                                        $transaction->commit();
                                        Yii::$app->session->setFlash('success', 'Success Input barang di wo');
                                    }else{
                                        $transaction->rollback();
                                        Yii::$app->session->setFlash('warning', 'Gagal Input barang di wo');
                                    }
                                    
                                }else{
                                    Yii::$app->session->setFlash('warning', 'Gagal update barang di wo');
                                    $transaction->rollback();
                                }
                            }else{
                                Yii::$app->session->setFlash('warning', 'Gagal update barang do');
                                $transaction->rollback();
                            }
                        }else{
                            //$produk->jml_now = $jml_now;
                            $produk->do_produk_status = 4;
                            if($produk->save()){
                                $model->wo = (int) $wo;
                                $model->produk = (int) $produk->produk;
                                $model->do_produk = (int) $produk->do_produk;
                                $model->wo_hpp = (int) $produk->do_harga;
                                $model->wo_produk_status = 'Ok';
                                $model->wo_jml = (int) $model->wo_jml;
                                $model->wo_harga = (int) $model->wo_harga;
                                $model->user_input = Yii::$app->user->identity->id;

                                //var_dump($model->validate());die;

                                if($model->save()){
                                    $transaction->commit();
                                    Yii::$app->session->setFlash('success', 'Success Input barang di wo');
                                }else{
                                    $transaction->rollback();
                                    Yii::$app->session->setFlash('warning', 'Gagal Input barang di wo');
                                }
                            }else{
                                Yii::$app->session->setFlash('warning', 'Gagal update barang do');
                                $transaction->rollback();
                            }
                        }
                    } catch (Exception $ex) {
                        Yii::$app->session->setFlash('warning', 'Error input barang wo');
                        $transaction->rollback();
                    }

                    //Yii::$app->session->setFlash('success', 'Data berhasil di input!');
                }else{
                    Yii::$app->session->setFlash('success', 'Jumlah wo lebih besar dari stok!');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Data tidak berhasil di update');
            }
                                
            return $this->redirect(['update',
                'wo' => $wo,
            ]);
        } else {
            return $this->renderAjax('_forminputwo', [
                'model' => $model,
            ]);
        }
    }

    public function actionOut()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->layout = 'api';
        $wo_produk = $_POST['wo_produk'];
        $produk = WoProdukT::findOne($wo_produk);
        $doproduk = DoProdukT::findOne($produk->do_produk);
        $doproduk->do_produk_status = 1;

        if($produk->delete() && $doproduk->save()){
            $data = array(
                'hasil' => 'success',
            );
        }else{
            $data = array(
                'hasil' => 'gagal',
            );
        }
        
        return $data;
    }

    
    public function actionBataljual($wo)
    {
        $model = $this->findModel($wo);
        $penjualan = $model->penjualan;
        $modProduk = WoProdukT::find()->where(['wo' => $wo])->asArray()->all();

        $countrak = WoProdukT::find()->where(['wo' => $wo])->asArray()->count();
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
                
                $modWo = WoT::findOne($model->wo);
                $modWo->status = 'Start';
                $modWo->penjualan = NULL;

                //var_dump($modRakitan->validate());die;
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
        return $this->redirect(['update', 'wo' => $wo]);
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
     * Deletes an existing WoT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $wo Wo
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($wo)
    {
        $model = $this->findModel($wo);
        try {
            if($model->delete()){
                Yii::$app->session->setFlash('sucess', 'Data berhasil dihapus');
            }else{
                Yii::$app->session->setFlash('warning', 'Data tidak hapus, hapus dulu semua item yang ada di wo');
            }
        } catch (Exception $ex) {
            //$transaction->rollback();
            Yii::$app->session->setFlash('warning', 'Data tidak hapus, hapus dulu semua item yang ada di wo');
            return $this->redirect(['index']);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the WoT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $wo Wo
     * @return WoT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($wo)
    {
        if (($model = WoT::findOne(['wo' => $wo])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

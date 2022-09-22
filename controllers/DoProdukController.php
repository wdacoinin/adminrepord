<?php

namespace app\controllers;

use Yii;
use yii\widgets\ActiveForm;
use app\models\DoProdukT;
use app\models\DoProduk;
use app\models\DoProdukSG;
use app\models\DoProdukTerjual;
use app\models\MerekT;
use app\models\ProdukT;
use app\models\Stokterjual;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DoProdukController implements the CRUD actions for DoProdukT model.
 */
class DoProdukController extends Controller
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
     * Lists all DoProdukT models.
     *
     * @return string
     */
    public function actionIndex($do)
    {
        $this->layout = 'kosong';
        $searchModel = new DoProduk();
        $dataProvider = $searchModel->search($this->request->queryParams, $do);

        return $this->render('index', [
            'do' => $do,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    
    /**
     * Lists all DoProdukT models.
     *
     * @return string
     */
    public function actionGlobal()
    {
        $this->layout = 'kosong';
        $searchModel = new DoProdukSG();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('_stokglobal', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    
    /**
     * Lists all stokterjualv models.
     *
     * @return string
     */
    public function actionStokterjual()
    {
        $this->layout = 'kosong';
        $searchModel = new Stokterjual();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('_stokterjual', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DoProdukT model.
     * @param int $do_produk Do Produk
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($do_produk)
    {
        $this->layout = 'kosong';
        return $this->render('view', [
            'model' => $this->findModel($do_produk),
        ]);
    }

    public function actionSmerek()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->layout = 'api';
        $prop = $_POST['depdrop_parents'];
        $id =$prop[0];

        //var_dump($day);die;
        $merek = ProdukT::find()->select('produk.merek, merek.nama')
        ->join("LEFT JOIN", "merek", "produk.merek=merek.merek")
        ->where(['kategori' => $id])
        ->groupBy('produk.merek')
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
        return ['output'=> $dt, 'selected'=>$selected];
    }

    /**
     * Creates a new DoProdukT model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($do)
    {
        $this->layout = 'kosong';
        $model = new DoProdukT();
        $model->do = $do;
        
        //validation
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                //return ActiveForm::validate($model);
            }

            if(isset($_POST['ajax']) && $model->validate()){
                //var_dump($model->validate());
                $check = DoProdukT::find()->where(['do' => $model->do, 'produk' => $model->produk, 'stok_jenis' => $model->stok_jenis])->count();
                if($check > 0){
                    Yii::$app->session->setFlash('warning', 'Nama sudah ada, update di produk tersebut, data tidak di simpan!');
                    //Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    $data = 'gagal';
                }else{
                    $model->jml_now = $model->do_jml;
                    if($model->save()) {
                        Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                        //Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        $data = $model->do;
                    } else {
                        Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                        //Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        $data = 'gagal';
                    }
                }
                return $data;
            }
            //var_dump($model);
            /* $check = DoProdukT::find()->where(['produk' => $model->produk, 'stok_jenis' => $model->stok_jenis])->count();
            if($check > 0){
                Yii::$app->session->setFlash('warning', 'Nama sudah ada, update di produk tersebut, data tidak di simpan!');
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $data = 'gagal';
            }else{
                $model->jml_now = $model->do_jml;
                if($model->save()) {
                    Yii::$app->session->setFlash('success', 'Data berhasil di simpan!');
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    $data = 'success';
                } else {
                    Yii::$app->session->setFlash('error', 'Data tidak berhasil di simpan');
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    $data = 'gagal';
                }
            }
            return $data; */
            //return $this->renderAjax('do-produk/update', ['model' => $model]);
            //return;
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
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
    public function actionUpdate($do_produk)
    {
        $this->layout = 'kosong';
        $model = $this->findModel($do_produk);

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
     * Deletes an existing DoProdukT model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $do_produk Do Produk
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($do_produk)
    {
        $this->findModel($do_produk)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DoProdukT model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $do_produk Do Produk
     * @return DoProdukT the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($do_produk)
    {
        if (($model = DoProdukT::findOne(['do_produk' => $do_produk])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

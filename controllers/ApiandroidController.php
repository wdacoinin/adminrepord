<?php

namespace app\controllers;

use app\models\AbsenT;
use yii;
use app\models\BackendUser;
use app\models\PengirimanT;
use app\models\SBackendUser;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Security;
use yii\widgets\ActiveForm;
use yii\helpers\FileHelper;
use app\models\UploadForm;
use Exception;

/**
 * BackendUserController implements the CRUD actions for BackendUser model.
 */
class ApiandroidController extends Controller
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
        $this->layout = 'kosong';
        $searchModel = new SBackendUser();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionVerify()
    {

        $model = new BackendUser();

            if (isset($_POST['username']) &&  $_POST['username'] !== '' && $_POST['password'] !== '') {
                $username = $_POST['username'];
                $password = $_POST['password'];
                //return ActiveForm::validate($model);

                $model = (new \yii\db\Query())
                ->select([
                'user.id', 
                'user.password', 
                'user.divisi', 
                'user.nama', 
                'divisi.nama AS nama_divisi'])
                ->from('user')
                ->join('LEFT JOIN', 'divisi', 'user.divisi = divisi.divisi')
                ->where(['user.username' => $username])
                ->all();
                $hash = $model[0]['password'];
                $moduser = User::findOne((int) $model[0]['id']);
                $user = array(
                    'id' =>$moduser->id,
                    'password' =>$moduser->password,
                    'username' =>$moduser->username,
                    'divisi' =>$moduser->divisi,
                    'nama' =>$moduser->nama,
                    'nama_divisi' =>$moduser->divisi0->nama,
                );
                //echo json_encode($model);
                
                if (Yii::$app->getSecurity()->validatePassword($password, $hash)) {
                    // password is good
                    $json = array(
                        'hasil' => 'success',
                        'message' => '',
                        'user' => $user
                    );
                }else{
                    $model = null;
                    $json = array(
                        'hasil' => 'Data Not Found.'
                    );
                }
            }else{
                $json = array(
                    'message' => 'Usernam / Pass Kosong',
                    'hasil' => 'Data Not Found.'
                );
            }
            echo json_encode($json);
    }

    public function actionCheckimg()
    {

        $model = AbsenT::find()->where(['id' => $_POST['id']])->andWhere("datetime LIKE '%".$_POST['datetime']."%'")->asArray()->one();

            if ($model != null) {
                
                $json = array(
                    'hasil' => 'ada',
                    'datetime' => $model['datetime'],
                    'url' => $model['url'],
                );
            }else{
                $json = array(
                    'hasil' => 0,
                );
            }
            echo json_encode($json);
    }

    public function actionSaveimg()
    {

        $model = new AbsenT();
        $UpForm = new UploadForm();
        $model->id = $_POST['id'];
        $model->datetime = date('Y-m-d H:i:s');

        $upload_dir = Yii::getAlias('@webroot') . '/uploads/absensi/';

        if (!file_exists($upload_dir)) //Buat folder
        //mkdir($upload_dir);
        FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);

        //image
        //$file = $_POST['img'];
        $size = $this->getBase64ImageSize($_POST['img']);
        //set build directory
        $url_database = Yii::$app->request->baseUrl . '/uploads/absensi/' . $_POST['nama']. '-'. date('Y-m-d') . '.' . $_POST['filetype'];
        $nama_foto = $_POST['nama']. '-'. date('Y-m-d') . '.' . $_POST['filetype'];
        $img_url = Yii::getAlias('@webroot') . '/uploads/absensi/' . $nama_foto;
        

        $image_parts = explode(";base64,", $_POST['img']);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $a = file_put_contents($img_url, $image_base64);
        
        $model->nama_foto = $nama_foto;
        $model->type = $_POST['filetype'];
        $model->size = $size;
        $model->url = $url_database;
        $model->lat = $_POST['lat'];
        $model->lon = $_POST['lon'];
        /* $json = array(
            'hasil' => $a
        ); */
        
            if ($model->save()) {
                
                $json = array(
                    'hasil' => 'success'
                );
            }else{
                $json = array(
                    'hasil' => 'gagal'
                );
            }
            echo json_encode($json);
    }

    public function actionAmbilfoto()
    {
        $pengiriman = (int) $_POST['pengiriman'];

        $model = PengirimanT::findOne($pengiriman);

        //var_dump($model);die;
        $UpForm = new UploadForm();
        $model->user = $_POST['user'];
        $model->datetime = date('Y-m-d H:i:s');

        $upload_dir = Yii::getAlias('@webroot') . '/uploads/pengiriman/';

        if (!file_exists($upload_dir)) //Buat folder
        //mkdir($upload_dir);
        FileHelper::createDirectory($upload_dir, $mode = 0775, $recursive = true);
        $ran = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,3);

        //image
        //$file = $_POST['img'];
        $size = $this->getBase64ImageSize($_POST['img']);
        //set build directory
        $url_database = Yii::$app->request->baseUrl . '/uploads/pengiriman/' . $_POST['nama']. '-'. date('Y-m-d') . '-' . $ran . '.' . $_POST['filetype'];
        $nama_foto = $_POST['nama']. '-'. date('Y-m-d') . '-' . $ran . '.' . $_POST['filetype'];
        $img_url = Yii::getAlias('@webroot') . '/uploads/pengiriman/' . $nama_foto;
        

        $image_parts = explode(";base64,", $_POST['img']);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $a = file_put_contents($img_url, $image_base64);
        
        $model->nama_foto = $nama_foto;
        $model->type = $_POST['filetype'];
        $model->size = $size;
        $model->url = $url_database;
        $model->lat = $_POST['lat'];
        $model->lon = $_POST['lon'];
        /* $json = array(
            'hasil' => $a
        ); */
        
            if ($model->save()) {
                
                $json = array(
                    'hasil' => 'success'
                );
            }else{
                $json = array(
                    'hasil' => 'gagal'
                );
            }
            echo json_encode($json);
    }

    public function getBase64ImageSize($base64Image){ //return memory size in B, KB, MB
        try{
            $size_in_bytes = (int) (strlen(rtrim($base64Image, '=')) * 3 / 4);
            /* $size_in_kb    = $size_in_bytes / 1024;
            $size_in_mb    = $size_in_kb / 1024; */
    
            return $size_in_bytes;
        }
        catch(Exception $e){
            return $e;
        }
    }

}

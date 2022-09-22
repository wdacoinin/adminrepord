<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //return $this->render('index');
        /* $model = new LoginForm();
        
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]); */

        $model = new LoginForm();
        $device = Yii::$app->params['devicedetect'];

        if (!Yii::$app->user->isGuest) {
            return $this->render('index', [
            'model' => $model,
        ]);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            
            $tipe = Yii::$app->user->identity->divisi;
            $divisi = [1];
            $sales = [3];
            if(in_array($tipe, $divisi) > 0){
                $this->redirect(array('/do-produk/global'));
            }else{
                $this->redirect(array('/penjualan'));
            }
                
            
        }

        /* if(Yii::$app->user->isGuest && $device['isDesktop'] != true){
            $this->redirect(array('/android'));
        }else{ */
            $model->password = '';
            return $this->render('index', [
                'model' => $model,
            ]);
        /* } */
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->render('login');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            
            $tipe = Yii::$app->user->identity->divisi;
            $hid = Yii::$app->user->identity->id;
            $id = [1,4];
            $divisi = [1];
            $sales = [3];
            if(in_array($tipe, $divisi) > 0){

                if(in_array($hid, $id) > 0){
                    $this->redirect(array('/board'));
                }else{
                    $this->redirect(array('/do-produk/global'));
                }
            }else{
                $this->redirect(array('/penjualan'));
            }
                
            
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}

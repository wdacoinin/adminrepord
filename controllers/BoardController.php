<?php

namespace app\controllers;

use yii;
use app\models\BackendUser;
use yii\web\NotFoundHttpException;
use app\models\User;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * DashboardsController implements the CRUD actions for BackendUser model.
 */
class BoardController extends Controller
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

    public function actionIndex()
    {

        $this->layout = 'kosong';
        return $this->render('index');

    }


}

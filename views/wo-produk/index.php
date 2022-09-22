<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WoProduk */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wo Produk Ts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wo-produk-t-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Wo Produk T', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'wo_produk',
            'wo',
            'produk',
            'do_produk',
            'wo_jml',
            //'wo_hpp',
            //'wo_harga',
            //'user_input',
            //'timestamp',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, WoProdukT $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'wo_produk' => $model->wo_produk]);
                 }
            ],
        ],
    ]); ?>


</div>

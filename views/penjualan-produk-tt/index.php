<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PenjualanProdukTt */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penjualan Produk Tt Ts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penjualan-produk-tt-t-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Penjualan Produk Tt T', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'penjualan_produk_tt',
            'penjualan',
            'produk',
            'do_produk',
            'do_jml',
            //'do_hpp',
            //'do_harga',
            //'user_input',
            //'nama_foto',
            //'type',
            //'size',
            //'url:url',
            //'tt_date',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, PenjualanProdukTtT $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'penjualan_produk_tt' => $model->penjualan_produk_tt]);
                 }
            ],
        ],
    ]); ?>


</div>

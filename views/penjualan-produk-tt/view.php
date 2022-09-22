<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanProdukTtT */

$this->title = $model->penjualan_produk_tt;
$this->params['breadcrumbs'][] = ['label' => 'Penjualan Produk Tt Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="penjualan-produk-tt-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'penjualan_produk_tt' => $model->penjualan_produk_tt], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'penjualan_produk_tt' => $model->penjualan_produk_tt], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'penjualan_produk_tt',
            'penjualan',
            'produk',
            'do_produk',
            'do_jml',
            'do_hpp',
            'do_harga',
            'user_input',
            'nama_foto',
            'type',
            'size',
            'url:url',
            'tt_date',
        ],
    ]) ?>

</div>

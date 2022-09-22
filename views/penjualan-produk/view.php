<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanProdukT */

$this->title = $model->penjualan_produk;
$this->params['breadcrumbs'][] = ['label' => 'Penjualan Produk Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="penjualan-produk-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'penjualan_produk' => $model->penjualan_produk], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'penjualan_produk' => $model->penjualan_produk], [
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
            'penjualan_produk',
            'penjualan',
            'produk',
            'pembelian_produk',
            'penjualan_jml',
            'penjualan_hpp',
            'penjualan_harga',
            'retur_qty',
            'retur_date',
            'timestamp',
        ],
    ]) ?>

</div>

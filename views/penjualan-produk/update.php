<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanProdukT */

$this->title = 'Update Penjualan Produk T: ' . $model->penjualan_produk;
$this->params['breadcrumbs'][] = ['label' => 'Penjualan Produk Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->penjualan_produk, 'url' => ['view', 'penjualan_produk' => $model->penjualan_produk]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="penjualan-produk-t-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

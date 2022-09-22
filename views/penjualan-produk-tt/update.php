<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanProdukTtT */

$this->title = 'Update Penjualan Produk Tt T: ' . $model->penjualan_produk_tt;
$this->params['breadcrumbs'][] = ['label' => 'Penjualan Produk Tt Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->penjualan_produk_tt, 'url' => ['view', 'penjualan_produk_tt' => $model->penjualan_produk_tt]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="list-group-item">
    <h1><?= Html::encode($this->title) ?></h1>

</div>
<div class="container-flex">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

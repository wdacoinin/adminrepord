<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanProduk */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="penjualan-produk-t-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'penjualan_produk') ?>

    <?= $form->field($model, 'penjualan') ?>

    <?= $form->field($model, 'produk') ?>

    <?= $form->field($model, 'pembelian_produk') ?>

    <?= $form->field($model, 'penjualan_jml') ?>

    <?php // echo $form->field($model, 'penjualan_hpp') ?>

    <?php // echo $form->field($model, 'penjualan_harga') ?>

    <?php // echo $form->field($model, 'retur_qty') ?>

    <?php // echo $form->field($model, 'retur_date') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

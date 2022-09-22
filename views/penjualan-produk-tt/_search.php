<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanProdukTt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="penjualan-produk-tt-t-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'penjualan_produk_tt') ?>

    <?= $form->field($model, 'penjualan') ?>

    <?= $form->field($model, 'produk') ?>

    <?= $form->field($model, 'do_produk') ?>

    <?= $form->field($model, 'do_jml') ?>

    <?php // echo $form->field($model, 'do_hpp') ?>

    <?php // echo $form->field($model, 'do_harga') ?>

    <?php // echo $form->field($model, 'user_input') ?>

    <?php // echo $form->field($model, 'nama_foto') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'size') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'tt_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

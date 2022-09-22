<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanProdukT */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="penjualan-produk-t-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'penjualan')->textInput() ?>

    <?= $form->field($model, 'produk')->textInput() ?>

    <?= $form->field($model, 'pembelian_produk')->textInput() ?>

    <?= $form->field($model, 'penjualan_jml')->textInput() ?>

    <?= $form->field($model, 'penjualan_hpp')->textInput() ?>

    <?= $form->field($model, 'penjualan_harga')->textInput() ?>

    <?= $form->field($model, 'retur_qty')->textInput() ?>

    <?= $form->field($model, 'retur_date')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Penjualan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="penjualan-t-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'penjualan') ?>

    <?= $form->field($model, 'penjualan_tgl') ?>

    <?= $form->field($model, 'penjualan_tempo') ?>

    <?= $form->field($model, 'konsumen') ?>

    <?= $form->field($model, 'faktur') ?>

    <?php // echo $form->field($model, 'surat_jalan') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'penjualan_ongkir') ?>

    <?php // echo $form->field($model, 'fee') ?>

    <?php // echo $form->field($model, 'fee_date') ?>

    <?php // echo $form->field($model, 'sales') ?>

    <?php // echo $form->field($model, 'penjualan_diskon') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'penjualan_status') ?>

    <?php // echo $form->field($model, 'akun') ?>

    <?php // echo $form->field($model, 'total_bahan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

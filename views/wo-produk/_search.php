<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WoProduk */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wo-produk-t-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'wo_produk') ?>

    <?= $form->field($model, 'wo') ?>

    <?= $form->field($model, 'produk') ?>

    <?= $form->field($model, 'do_produk') ?>

    <?= $form->field($model, 'wo_jml') ?>

    <?php // echo $form->field($model, 'wo_hpp') ?>

    <?php // echo $form->field($model, 'wo_harga') ?>

    <?php // echo $form->field($model, 'user_input') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

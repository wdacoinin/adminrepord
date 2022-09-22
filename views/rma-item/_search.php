<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RmaItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rma-item-t-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'rma_item') ?>

    <?= $form->field($model, 'rma') ?>

    <?= $form->field($model, 'produk') ?>

    <?= $form->field($model, 'rma_jml') ?>

    <?= $form->field($model, 'rma_harga') ?>

    <?php // echo $form->field($model, 'rma_ket') ?>

    <?php // echo $form->field($model, 'nama_foto') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'size') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'id_user') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

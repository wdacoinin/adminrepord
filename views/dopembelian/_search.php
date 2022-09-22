<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dopembelian */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dopembelianv-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'do') ?>

    <?= $form->field($model, 'do_tgl') ?>

    <?= $form->field($model, 'supplier_nama') ?>

    <?= $form->field($model, 'faktur') ?>

    <?= $form->field($model, 'do_tempo') ?>

    <?php // echo $form->field($model, 'no_sj') ?>

    <?php // echo $form->field($model, 'nama') ?>

    <?php // echo $form->field($model, 'do_diskon') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'ppn') ?>

    <?php // echo $form->field($model, 'total_plus_ppn') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

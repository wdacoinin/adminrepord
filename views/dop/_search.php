<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dop */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dop-t-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'do') ?>

    <?= $form->field($model, 'do_tgl') ?>

    <?= $form->field($model, 'supplier') ?>

    <?= $form->field($model, 'do_status') ?>

    <?= $form->field($model, 'us') ?>

    <?php // echo $form->field($model, 'faktur') ?>

    <?php // echo $form->field($model, 'do_tempo') ?>

    <?php // echo $form->field($model, 'no_sj') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'do_diskon') ?>

    <?php // echo $form->field($model, 'ppn') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AkunSaldo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akun-saldo-t-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'akun_saldo') ?>

    <?= $form->field($model, 'aktiva') ?>

    <?= $form->field($model, 'akun') ?>

    <?= $form->field($model, 'noref') ?>

    <?= $form->field($model, 'ket') ?>

    <?php // echo $form->field($model, 'jml') ?>

    <?php // echo $form->field($model, 'datetime') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'nama_foto') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'size') ?>

    <?php // echo $form->field($model, 'url') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SupplierT */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['id' => 'update', 'enableAjaxValidation' => true]); ?>
<div class="col-md-12">

    <?= $form->field($model, 'supplier_nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'supplier_detail')->textInput(['maxlength' => true]) ?>


</div>
<div class="list-group-item">
    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

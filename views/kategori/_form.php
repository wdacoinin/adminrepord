<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\KategoriT */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['id' => 'update', 'enableAjaxValidation' => true]); ?>
<div class="col-md-12">

    <?= $form->field($model, 'kategori_nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kategori_urutan')->textInput(['maxlength' => true]) ?>

</div>
<div class="list-group-item">
    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

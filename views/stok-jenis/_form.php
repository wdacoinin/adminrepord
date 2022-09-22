<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\StokJenisT */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['id' => 'update', 'enableAjaxValidation' => true]); ?>
<div class="col-md-12">


    <?= $form->field($model, 'stok_jenis_nama')->textInput(['maxlength' => true]) ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'stok_jenis_status')->widget(Select2::classname(), [
        'data' => ['1' => 'Aktif', '0' => 'Non Aktif'],
        'options' => ['placeholder' => 'Pilih'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

</div>
<div class="list-group-item">
    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

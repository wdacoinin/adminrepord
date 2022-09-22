<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\Divisi;
use yii\helpers\ArrayHelper;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model app\models\BackendUser */
/* @var $form yii\widgets\ActiveForm */

$dispOptions = ['class' => 'form-control'];
    
$saveOptions = [
    'type' => 'hidden', 
    'label'=>'', 
    'class' => 'form-control',
    'readonly' => true, 
    'tabindex' => 1000
];

$saveCont = ['class' => 'kv-saved-cont'];
$modDivisi = ArrayHelper::map(Divisi::find()->where('divisi > 1')->asArray()->all(), 'divisi', 'nama');
?>

<div class="col-md-12">

    <?php $form = ActiveForm::begin(['id' => 'create', 'enableAjaxValidation' => true]); ?> 

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'divisi')->widget(Select2::classname(), [
        'data' => $modDivisi,
        'options' => ['placeholder' => 'Pilih Divisi'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <?php
    // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
    // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
    // is disallowed.
    echo $form->field($model, 'gaji')->widget(NumberControl::classname(), [
        'maskedInputOptions' => [
            'prefix' => 'Rp. ',
            'groupSeparator' => '.',
            'radixPoint' => ',',
            'allowMinus' => false
        ],
        'options' => $saveOptions,
        'displayOptions' => $dispOptions,
        'saveInputContainer' => $saveCont
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<style>	
	.hide {
		display: none;
	}
	.alert,
	.alert .close{
		padding: .55rem;
	}
</style>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\InventoriT;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model app\models\RakitanT */
/* @var $form yii\widgets\ActiveForm */
/* $initialPreview = $model->url;
$initialPreviewConfig[] = array(
    'key' => $model->rakitan,
    'url' => 'index.php?r=rakitan/deletefile',
    'caption' => $model->nama_foto,
    'size' => $model->size,
); */

$dispOptions = ['class' => 'form-control'];
$saveOptions = [
    'type' => 'hidden', 
    'label'=>'', 
    'class' => 'form-control',
    'readonly' => true, 
    'tabindex' => 1000
];
$saveCont = ['class' => 'kv-saved-cont'];
?>

<?php $form = ActiveForm::begin([
    'id' => 'out-rakitan', 
    'enableAjaxValidation' => true
]); ?>

<div class="row">

    <?= // Usage with ActiveForm and model
    $form->field($model, 'inventori')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(InventoriT::find()->where('lokasi <> 1')->orderBy('kode')->asArray()->all(), 'inventori', 'kode'),
        'options' => [
        'readonly' => true, 
        'placeholder' => 'Pilih', 'value' => $model->inventori
        ],
        'pluginOptions' => [
            'allowClear' => false,
            'dropdownParent' => '#modal'
        ],
    ])->label('Lokasi *isi jika barang out dari rakitan'); 
    ?>
    
    <?php
    // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
    // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
    // is disallowed.
    echo $form->field($model, 'harga_jual')->widget(NumberControl::classname(), [
        'maskedInputOptions' => [
            'prefix' => 'Rp. ',
            'groupSeparator' => '.',
            //'radixPoint' => ',',
            'digits' => 0,
            'allowMinus' => false
        ],
        'options' => $saveOptions,
        'displayOptions' => $dispOptions,
        'saveInputContainer' => $saveCont
    ]);
    ?>

</div>
<div class="list-group-item mt-2">
        <?= Html::submitButton('<i class="align-middle" data-feather="arrow-down-circle"></i> Update', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

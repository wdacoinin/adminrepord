<?php

use app\models\DopT;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\ReturT */
/* @var $form yii\widgets\ActiveForm */
$today = date('Y-m-d');
?>


<?php $form = ActiveForm::begin([
        'id' => 'retur', 
        'enableAjaxValidation' => true
    ]); ?>
<div class="col-md-12">

    <?= // Usage with ActiveForm and model
    $form->field($model, 'do')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(DopT::find()
        ->select(["do.do, CONCAT(do.faktur, ' - ', supplier.supplier_nama) AS faktur"])
        ->join("LEFT JOIN", "supplier", "do.supplier=supplier.supplier")
        ->orderBy('do.faktur')->asArray()->all(), 'do', 'faktur'),
        'options' => ['placeholder' => 'Pilih'],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => '#modal'
        ],
    ]); 
    ?>

    <?= $form->field($model, 'noretur')->textInput(['maxlength' => true, 'readonly' => true])->label('No.Retur') ?>

    <?=
    $form->field($model, 'date')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Tgl.Penjualan', 'value' => $today],
        'pluginOptions' => [
            'todayHighlight' => true,
            'calendarWeeks' => true,
            //'daysOfWeekDisabled' => [0, 6],
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>

    <?= $form->field($model, 'user')->textInput(['hidden' => true, 'value' => Yii::$app->user->identity->id])->label(false) ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'retur_status')->widget(Select2::classname(), [
        'data' => [1 => 'Proses', 2 => 'Selesai Replace barang beda', 3 => 'Selesai diganti uang', 4 => 'Selesai replace barang identik'],
        'options' => ['placeholder' => 'Pilih', 'value' => 1],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => '#modal'
        ],
    ]); 
    ?>


    <?= $form->field($model, 'keterangan')->textarea() ?>
    

    <?php if($action > 0){?>
        <?= $form->field($UpForm, 'file')->widget(FileInput::classname(), [
            'pluginOptions' => [
                'previewFileType' => 'any',
                'initialPreviewAsData'=>true,
                'initialPreview'=>$initialPreview,
                'initialCaption'=>true,
                'initialPreviewConfig' => $initialPreviewConfig,
                'overwriteInitial'=>false,
                'showPreview' => true,
                'showCaption' => true,
                'showRemove' => false,
                'showUpload' => false,
                'showFileInput' => false
            ],
        ]); ?>
    <?php }else{?>
        
        <?= $form->field($UpForm, 'file')->widget(FileInput::classname(), [
            'pluginOptions' => [
                'showPreview' => true,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => false
            ],
        ]); ?>
    <?php }?>


</div>
<div class="list-group-item">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
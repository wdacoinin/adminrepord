<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\SupplierT;
use app\models\VariableT;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model app\models\DopT */
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

$today = date('Y-m-d');
$tempo = date('Y-m-d', strtotime(' +25 day'));

$ppnv = VariableT::find()->select('val')->where('variable = 4')->one();
$ppn = $ppnv['val'];
?>


<?php $form = ActiveForm::begin(['id' => 'create', 'enableAjaxValidation' => true]); ?>
<div class="col-md-12">

<div class="row">
    <div class="col-md-6">

        <?= $form->field($model, 'faktur')->textInput(['maxlength' => true, 'readonly' => true]) ?>

        <?= $form->field($model, 'no_sj')->textInput(['maxlength' => true]) ?>

        <?= // Usage with ActiveForm and model
        $form->field($model, 'supplier')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(SupplierT::find()->orderBy('supplier_nama ASC')->asArray()->all(), 'supplier', 'supplier_nama'),
            'options' => ['placeholder' => 'Pilih'],
            'pluginOptions' => [
                'allowClear' => true,
                'dropdownParent' => '#modal'
            ],
        ]);
        ?>

        <?php
        // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
        // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
        // is disallowed.
        echo $form->field($model, 'do_diskon')->widget(NumberControl::classname(), [
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

        <?= // Usage with ActiveForm and model
        $form->field($model, 'ppn')->widget(Select2::classname(), [
            'data' => [$ppn => 'Exclude', 0 => 'Include Ppn'],
            'options' => ['placeholder' => 'Pilih', 'value' => $model->ppn],
            'pluginOptions' => [
                'allowClear' => true,
                'dropdownParent' => '#modal'
            ],
        ]);
        ?>

        <?= $form->field($model, 'us')->textInput(['hidden' => true, 'value' => Yii::$app->user->identity->id])->label(false) ?>

    </div>
    <div class="col-md-6">

        <?=
        $form->field($model, 'do_tgl')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Tgl.Pembelian', 'value' => $today],
            'pluginOptions' => [
                'todayHighlight' => true,
                'calendarWeeks' => true,
                //'daysOfWeekDisabled' => [0, 6],
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]);
        ?>

        <?=
        $form->field($model, 'do_tempo')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Tgl.Tempo', 'value' => $tempo],
            'pluginOptions' => [
                'todayHighlight' => true,
                'calendarWeeks' => true,
                //'daysOfWeekDisabled' => [0, 6],
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]);
        ?>

        <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'do_status')->textInput(['readonly' => true, 'value' => 'Hutang']) ?>

    </div>
</div>
<div class="list-group-item">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
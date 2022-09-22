<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\SupplierT;
use app\models\VariableT;
use app\models\DoProduk;
use kartik\number\NumberControl;
use yii\bootstrap5\Modal;

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


    <div class="col-md-5">
    <?php $form = ActiveForm::begin(['id' => 'update', 'enableAjaxValidation' => true]); ?>

    <div class="row p-0">
        <div class="col-md-6">

            <?= $form->field($model, 'faktur')->textInput(['maxlength' => true, 'readonly' => true]) ?>

            <?= $form->field($model, 'no_sj')->textInput(['maxlength' => true]) ?>

            <?= // Usage with ActiveForm and model
            $form->field($model, 'supplier')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(SupplierT::find()->orderBy('supplier_nama ASC')->asArray()->all(), 'supplier', 'supplier_nama'),
                'options' => ['placeholder' => 'Pilih'],
                'pluginOptions' => [
                    'allowClear' => true
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
                'data' => [$ppn => 'Exclude', 0 => 'Include / No Ppn'],
                'options' => ['placeholder' => 'Pilih', 'value' => $model->ppn],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>

            <?= $form->field($model, 'us')->textInput(['readonly' => true, 'value' => $model->us]) ?>

        </div>
        <div class="col-md-6">

            <?=
            $form->field($model, 'do_tgl')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Tgl.Pembelian', 'value' => $model->do_tgl],
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
                'options' => ['placeholder' => 'Tgl.Tempo', 'value' => $model->do_tempo],
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

            <?= // Usage with ActiveForm and model
            $form->field($model, 'do_status')->widget(Select2::classname(), [
                'data' => ['Hutang' => 'Hutang', 'Lunas' => 'Lunas', 'TT' => 'Tukar Tambah', 'Konsinyasi' => 'Konsinyasi'],
                'options' => ['placeholder' => 'Pilih', 'value' => $model->do_status],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
    </div>
    <div class="list-group-item">
            <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>

    <div id="list-produk" class="col-md-7"> 
            <?= $this->render('../dopembelian/_tableproduk', [
                'do' => $model->do,
                'searchModel' => $searchModel2, 
                'dataProvider' => $dataProvider2
            ]) ?>
    </div>

<style>
    .form-group {
        margin-bottom: 4px !important;
    }

    .control-label {
        margin-bottom: 2px !important;
    }

    .hide {
        display: none;
    }

    .modal {
        overflow-y: auto;
    }
    #modal3 .modal-header{
        background-color: #666;
    }
    .modal-xl {
    max-width: 90% !important;
    }
</style>
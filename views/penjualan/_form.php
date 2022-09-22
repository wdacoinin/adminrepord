<?php

use app\models\AkunT;
use app\models\BackendUser;
use app\models\KonsumenT;
use app\models\User;
use kartik\date\DatePicker;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanT */
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
$tempo = date('Y-m-d', strtotime(' +3 day'));
?>

<div class="penjualan-t-form">

    <?php $form = ActiveForm::begin([
        'id' => 'update-penjualan', 
        'enableAjaxValidation' => true
    ]); ?>

    <div class="col-md-12">
    <div class="row">
        <div class="col-md-6">

        <?=
        $form->field($model, 'penjualan_tgl')->widget(DatePicker::classname(), [
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

        <?=
        $form->field($model, 'penjualan_tempo')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Tgl.Tempo'],
            'pluginOptions' => [
                'todayHighlight' => true,
                'calendarWeeks' => true,
                //'daysOfWeekDisabled' => [0, 6],
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]);
        ?>

        <?= $form->field($model, 'faktur')->textInput(['maxlength' => true, 'readonly' => true]) ?>

        <?= $form->field($model, 'penjualan_status')->textInput(['readonly' => true]) ?>

        <?= // Usage with ActiveForm and model
        $form->field($model, 'penjualan_type')->widget(Select2::classname(), [
            'data' => ['Umum' => 'Umum', 'Project' => 'Project'],
            'options' => ['placeholder' => 'Pilih'],
            'pluginOptions' => [
                'allowClear' => true,
                'dropdownParent' => '#modal'
            ],
        ]);
        ?>

        <?= // Usage with ActiveForm and model
        $form->field($model, 'konsumen')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(KonsumenT::find()->select(["konsumen, CONCAT(konsumen_nama, ' Telp:', konsumen_telp) AS konsumen_nama"])->orderBy('konsumen_nama ASC')->asArray()->all(), 'konsumen', 'konsumen_nama'),
            'options' => ['placeholder' => 'Pilih'],
            'pluginOptions' => [
                'allowClear' => true,
                'dropdownParent' => '#modal'
            ],
        ]);
        ?>

        <?= $form->field($model, 'konsumen_nama')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'konsumen_telp')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'surat_jalan')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-6">

        <?=
        $form->field($model, 'fee_date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Tgl.Fee'],
            'pluginOptions' => [
                'todayHighlight' => true,
                'calendarWeeks' => true,
                //'daysOfWeekDisabled' => [0, 6],
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]);
        ?>
            
        <?= // Usage with ActiveForm and model
        $form->field($model, 'sales')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(BackendUser::find()->where('divisi >= 2')->orderBy('nama ASC')->asArray()->all(), 'id', 'nama'),
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
        echo $form->field($model, 'penjualan_diskon')->widget(NumberControl::classname(), [
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

        <?= $form->field($model, 'user')->textInput(['hidden' => true, 'value' => Yii::$app->user->identity->id])->label(false) ?>

        <?= // Usage with ActiveForm and model
        $form->field($model, 'akun')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(AkunT::find()->select(["akun, CONCAT(akun_nama, ' rek:', akun_ref) AS akun_nama"])->orderBy('akun_nama ASC')->asArray()->all(), 'akun', 'akun_nama'),
            'options' => ['placeholder' => 'Pilih'],
            'pluginOptions' => [
                'allowClear' => true,
                'dropdownParent' => '#modal'
            ],
        ]);
        ?>

        <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>
    
        <?php
        // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
        // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
        // is disallowed.
        echo $form->field($model, 'penjualan_ongkir')->widget(NumberControl::classname(), [
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
    
        <?php
        // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
        // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
        // is disallowed.
        echo $form->field($model, 'fee')->widget(NumberControl::classname(), [
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

        </div>

    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

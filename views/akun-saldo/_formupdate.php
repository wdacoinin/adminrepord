<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\number\NumberControl;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\AkunT;
use app\models\AktivaT;
use app\models\BebanJenisT;
use app\models\BebanT;
use kartik\datetime\DateTimePicker;
use kartik\widgets\FileInput;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\AkunSaldoT */
/* @var $form yii\widgets\ActiveForm */
$initialPreview = $model->url;
$initialPreviewConfig[] = array(
    'key' => $model->akun_saldo,
    'url' => 'index.php?r=akun-saldo/deletefile',
    'caption' => $model->nama_foto,
    'size' => $model->size,
);

$dispOptions = ['class' => 'form-control'];
$saveOptions = [
    'type' => 'hidden', 
    'label'=>'', 
    'class' => 'form-control',
    'readonly' => true, 
    'tabindex' => 1000
];
$saveCont = ['class' => 'kv-saved-cont'];

$today = date('Y-m-d H:m');
?>


<?php $form = ActiveForm::begin(['id' => 'update', 'enableAjaxValidation' => true]); ?>

<div class="row p-0">
<div class="col-md-6">

    <?=
    $form->field($model, 'datetime')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Tgl', 'value' => $today],
        'pluginOptions' => [
            'todayHighlight' => true,
            'calendarWeeks' => true,
            //'daysOfWeekDisabled' => [0, 6],
            'autoclose' => true,
            'format' => 'yyyy-mm-dd H:m'
        ]
    ]);
    ?>

    <?= $form->field($model, 'notrans')->textInput() ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'aktiva')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(AktivaT::find()->select(["aktiva, CONCAT(aktiva_nama, ' -> ', d_k) AS aktiva_nama"])->orderBy('aktiva_nama ASC')->asArray()->all(), 'aktiva', 'aktiva_nama'),
        'options' => ['placeholder' => 'Pilih'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'beban')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(BebanT::find()->select('beban, nama')->asArray()->all(), 'beban', 'nama'),
        'options' => ['placeholder' => 'Pilih', 'value' => $model->beban],
        'pluginOptions' => [
            'allowClear' => false,
            'dropdownParent' => '#modal'
        ],
    ]);
    ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'akun')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(AkunT::find()->select(["akun, CONCAT(akun_nama, '-', akun_ref, ' An.', an) AS akun_ref"])->orderBy('akun_ref ASC')->asArray()->all(), 'akun', 'akun_ref'),
        'options' => ['placeholder' => 'Pilih'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'noref')->textInput(['hidden' => true])->label(false) ?>

    <?php
    // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
    // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
    // is disallowed.
    echo $form->field($model, 'jml')->widget(NumberControl::classname(), [
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

    <?= $form->field($model, 'ket')->textarea(['rows' => 6]) ?>

</div>
<div class="col-md-6">

    <?= $form->field($model, 'user')->textInput(['hidden' => true, 'value' => $model->user])->label(false) ?>

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
</div>
<div class="list-group-item">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
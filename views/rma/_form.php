<?php

use app\models\KonsumenT;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\RmaT */
/* @var $form yii\widgets\ActiveForm */
$today = date('Y-m-d');
?>


<?php $form = ActiveForm::begin(); ?>
<div class="col-md-12">

    <?= // Usage with ActiveForm and model
    $form->field($model, 'rma_status')->widget(Select2::classname(), [
        'data' => ['Proses' => 'Proses', 'Selesai' => 'Selesai'],
        'options' => ['placeholder' => 'Pilih'],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => '#modal'
        ],
    ]); 
    ?>

    <?= $form->field($UpForm, 'file')->widget(FileInput::classname(), [
        'pluginOptions' => [
            'showPreview' => true,
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => false
        ],
    ]); ?>

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

    <?=
    $form->field($model, 'rma_date')->widget(DatePicker::classname(), [
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


</div>
<div class="list-group-item">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
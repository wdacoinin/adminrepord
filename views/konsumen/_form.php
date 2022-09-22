<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\KonsumenT */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['id' => 'update', 'enableAjaxValidation' => true]); ?>
<div class="col-md-12">

    <?= $form->field($model, 'konsumen_nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'konsumen_telp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alamat')->textarea(['rows' => 6]) ?>

    <?=
    $form->field($model, 'timestamp')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Tgl'],
        'pluginOptions' => [
            'todayHighlight' => true,
            'calendarWeeks' => true,
            'daysOfWeekDisabled' => [0, 6],
            'autoclose' => true,
            'format' => 'yyyy-mm-dd h:m:s'
        ]
    ]);
    ?>

</div>
<div class="list-group-item">
    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
</div>


<?php ActiveForm::end(); ?>

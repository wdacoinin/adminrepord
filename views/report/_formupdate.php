<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\ReportT */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>
<div class="col-md-12">

    <?= $form->field($model, 'report_detail')->textarea(['rows' => 6]) ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'report_status')->widget(Select2::classname(), [
        'data' => [1 => 'Report', 2 => 'Selesai'],
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
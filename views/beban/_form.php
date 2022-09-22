<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\BebanJenisT;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\BebanT */
/* @var $form yii\widgets\ActiveForm */
$modbj = ArrayHelper::map(BebanJenisT::find()->groupBy('beban_jenis')->asArray()->all(), 'beban_jenis', 'beban_jenis_nama');
?>

<?php $form = ActiveForm::begin(['id' => 'update', 'enableAjaxValidation' => true]); ?>
<div class="col-md-12">

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'beban_jenis')->widget(Select2::classname(), [
        'data' => $modbj,
        'options' => ['placeholder' => 'Jenis Beban'],
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

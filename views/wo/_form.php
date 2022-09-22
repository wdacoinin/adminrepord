<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\KonsumenT;

/* @var $this yii\web\View */
/* @var $model app\models\WoT */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>
<div class="col-md-12">

    <?= $form->field($model, 'status')->textInput(['maxlength' => true, 'readonly' => true, 'value' => 'Start']) ?>

    <?= $form->field($model, 'id_user')->textInput(['hidden' => true, 'value' => Yii::$app->user->identity->id])->label(false) ?>

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


</div>
<div class="list-group-item">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
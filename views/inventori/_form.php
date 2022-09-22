<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\LokasiT;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\InventoriT */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>
<div class="col-md-12">

    <?= // Usage with ActiveForm and model
    $form->field($model, 'lokasi')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(LokasiT::find()->orderBy('nama ASC')->asArray()->all(), 'lokasi', 'nama'),
        'options' => ['placeholder' => 'Pilih'],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => '#modal'
        ],
    ]);
    ?>

    <?= $form->field($model, 'kode')->textInput(['maxlength' => true]) ?>


</div>
<div class="list-group-item">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
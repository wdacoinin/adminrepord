<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\KategoriT;
use app\models\MerekT;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\ProdukT */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['id' => 'update', 'enableAjaxValidation' => true]); ?>
<div class="col-md-12">

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'kategori')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(KategoriT::find()->asArray()->all(), 'kategori', 'kategori_nama'),
        'options' => ['placeholder' => 'Pilih'],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => '#modal'
        ],
    ]); 
    ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'merek')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(MerekT::find()->asArray()->all(), 'merek', 'nama'),
        'options' => ['placeholder' => 'Pilih'],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => '#modal'
        ],
    ]); 
    ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'status')->widget(Select2::classname(), [
        'data' => ['1' => 'Aktif', '0' => 'Non Aktif'],
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

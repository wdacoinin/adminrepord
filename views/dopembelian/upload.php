<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\number\NumberControl;
use kartik\widgets\FileInput;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'File Nota';

?>


<?php $form = ActiveForm::begin(['id' => 'file-insert', 'enableAjaxValidation' => true, 'options' => ['enctype' => 'multipart/form-data']]); ?>


    <div class="col-md-12">
    <?= $form->field($UpForm, 'file')->widget(FileInput::classname(), [
        'pluginOptions' => [
            'showPreview' => true,
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => false
        ],
    ]); ?>

    <?= $form->field($DocPemb, 'do')->textInput(['hidden' => true])->label(false) ?>

    </div>
    <div class="form-group p-3">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

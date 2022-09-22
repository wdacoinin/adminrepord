<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RmaItemT */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>
<div class="col-md-12">

    <?= $form->field($model, 'rma')->textInput() ?>

    <?= $form->field($model, 'rma_jml')->textInput() ?>

    <?= $form->field($model, 'rma_harga')->textInput() ?>

    <?= $form->field($model, 'rma_ket')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'nama_foto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'size')->textInput() ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_user')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>


</div>
<div class="list-group-item">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
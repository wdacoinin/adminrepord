<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanProdukTtT */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>
<div class="col-md-12">

    <?= $form->field($model, 'penjualan')->textInput() ?>

    <?= $form->field($model, 'produk')->textInput() ?>

    <?= $form->field($model, 'do_produk')->textInput() ?>

    <?= $form->field($model, 'do_jml')->textInput() ?>

    <?= $form->field($model, 'do_hpp')->textInput() ?>

    <?= $form->field($model, 'do_harga')->textInput() ?>

    <?= $form->field($model, 'user_input')->textInput() ?>

    <?= $form->field($model, 'nama_foto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'size')->textInput() ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tt_date')->textInput() ?>


</div>
<div class="list-group-item">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
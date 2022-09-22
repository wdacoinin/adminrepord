<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WoProdukT */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>
<div class="col-md-12">

    <?= $form->field($model, 'wo')->textInput() ?>

    <?= $form->field($model, 'produk')->textInput() ?>

    <?= $form->field($model, 'do_produk')->textInput() ?>

    <?= $form->field($model, 'wo_jml')->textInput() ?>

    <?= $form->field($model, 'wo_hpp')->textInput() ?>

    <?= $form->field($model, 'wo_harga')->textInput() ?>

    <?= $form->field($model, 'user_input')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>


</div>
<div class="list-group-item">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
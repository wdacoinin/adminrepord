<?php

use app\models\DoProdukT;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Retur */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="retur-t-search">

    <?php $form = ActiveForm::begin([
        'id' => 'cari', 
        'enableAjaxValidation' => true
    ]); ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'do_produk')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(
            DoProdukT::find()
            ->select(["do_produk.do_produk, CONCAT(produk.produk, '-', do_produk.do_produk, ' nama: ', produk.nama) AS produk_nama"])
            ->join("LEFT JOIN", "produk", "do_produk.produk=produk.produk")
            ->where(['do_produk.do' => $model->do, 'do_produk.do_produk_origin' => 0])
            ->asArray()->all(), 'do_produk', 'produk_nama'),
        'options' => ['placeholder' => 'Pilih'],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => '#modal3'
        ],
    ]); 
    ?>

    <?= $form->field($model, 'qty_retur')->textInput(['type' => 'number', 'step' => 1, 'min' => 1]) ?>

    <div class="form-group">
        <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

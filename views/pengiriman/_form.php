<?php

use app\models\BackendUser;
use app\models\PenjualanT;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PengirimanT */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>
<div class="col-md-12">

    <small> Input dengan tanda *harus diisi.</small>
    <?= $form->field($model, 'surat_jalan')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'penjualan')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(PenjualanT::find()
        ->select(["penjualan.penjualan, CONCAT(penjualan.faktur, ' - ', konsumen.konsumen_nama) AS faktur"])
        ->join("LEFT JOIN", "konsumen", "penjualan.konsumen=konsumen.konsumen")
        ->orderBy('faktur')->asArray()->all(), 'penjualan', 'faktur'),
        'options' => ['placeholder' => 'Pilih'],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => '#modal'
        ],
    ])->label('No.Penjualan, kosongkan jika bukan penjualan'); 
    ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'user')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(BackendUser::find()->where('divisi > 1')->orderBy('nama')->asArray()->all(), 'id', 'nama'),
        'options' => ['placeholder' => 'Pilih'],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => '#modal'
        ],
    ])->label('*Pengirim Barang'); 
    ?>

    <?= $form->field($model, 'nama_penerima')->textInput(['maxlength' => true])->label('Penerima / Pemberi Barang') ?>

    <?= $form->field($model, 'cp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Alamat')->textarea(['rows' => 4])->label('*Alamat Kirim') ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>


</div>
<div class="list-group-item">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
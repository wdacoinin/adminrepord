<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\ProdukT;
use app\models\KategoriT;
use app\models\StokJenisT;
use app\models\MerekT;
use kartik\number\NumberControl;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\DoProdukT */
/* @var $form yii\widgets\ActiveForm */
$action = Url::to(['/do-produk/create']);
$actionback = Url::to(['/dop/update', 'do' => $model->do]);

$dispOptions = ['class' => 'form-control'];
$saveOptions = [
    'type' => 'hidden', 
    'label'=>'', 
    'class' => 'form-control',
    'readonly' => true, 
    'tabindex' => 1000
];
$saveCont = ['class' => 'kv-saved-cont'];
$today = date('Y-m-d');
?>


<?php $form = ActiveForm::begin([
    'id' => 'create-produk', 
    'enableAjaxValidation' => true
    ]); ?>
<div class="col-md-12">

    <?php
    echo '<label class="control-label">Kategori</label>';
    echo Select2::widget([
        'name' => 'kategori',
        'data' => ArrayHelper::map(KategoriT::find()->orderBy('kategori_nama ASC')->asArray()->all(), 'kategori', 'kategori_nama'),
        'options' => [
            'id' => 'kategori',
            'placeholder' => 'Pilih Kategori ...',
        ],
    ]);
    ?>

    <?php
    echo '<label class="control-label">Merek</label>';
    echo DepDrop::widget([
        'name' => 'merek',
        'options'=>[
            'id' => 'merek',
        ],
        'pluginOptions' => [
            'depends' => ['kategori'],
            //'initialize' => true,
            'initDepends' => ['kategori'],
            //'params' => ['reservasipasient-tglreservasi'],
            //'placeholder'=> $model->IDJadwal,
            'url' => Url::to(['/do-produk/smerek'])
        ],
    ]);

    echo $form->field($model, 'produk')->widget(DepDrop::classname(), [
        'data' => [$model->produk => $model->produk],
        'options' => ['id' => 'produk'],
        'pluginOptions' => [
            'depends' => ['merek'],
            'initialize' => true,
            'initDepends' => ['merek'],
            'params' => ['kategori'],
            //'placeholder'=> $model->IDJadwal,
            'url' => Url::to(['/do-produk/sproduk'])
        ],
    ]);
    ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'stok_jenis')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(StokJenisT::find()->where(['stok_jenis_status' => 1])->orderBy('stok_jenis ASC')->asArray()->all(), 'stok_jenis', 'stok_jenis_nama'),
        'options' => ['placeholder' => 'Pilih'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'do_jml')->textInput(['type' => 'number', 'step' => 1, 'min' => 1]) ?>

    <?php
    // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
    // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
    // is disallowed.
    echo $form->field($model, 'do_harga')->widget(NumberControl::classname(), [
        'maskedInputOptions' => [
            'prefix' => 'Rp. ',
            'groupSeparator' => '.',
            'radixPoint' => ',',
            'allowMinus' => false
        ],
        'options' => $saveOptions,
        'displayOptions' => $dispOptions,
        'saveInputContainer' => $saveCont
    ]);
    ?>

    <?php
    // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
    // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
    // is disallowed.
    echo $form->field($model, 'harga_jual')->widget(NumberControl::classname(), [
        'maskedInputOptions' => [
            'prefix' => 'Rp. ',
            'groupSeparator' => '.',
            'radixPoint' => ',',
            'allowMinus' => false
        ],
        'options' => $saveOptions,
        'displayOptions' => $dispOptions,
        'saveInputContainer' => $saveCont
    ]);
    ?>

    <?= $form->field($model, 'jml_now')->textInput(['hidden' => true])->label(false) ?>

    <?= $form->field($model, 'do_produk_date')->textInput(['hidden' => true, 'value' => $today])->label(false) ?>

    <?= $form->field($model, 'do_produk_date_stok')->textInput(['hidden' => true])->label(false) ?>

</div>
<div class="list-group-item">
        <?= Html::Button('Simpan Produk', ['id' => 'sproduk', 'class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
<?php

use app\models\DoProdukT;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\InventoriT;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\KategoriT;
use app\models\StokJenisT;
use kartik\widgets\FileInput;
use kartik\depdrop\DepDrop;
use kartik\number\NumberControl;
use yii\helpers\Url;

$controller = Yii::$app->controller;
$actionqty = 'index.php?r=' . $controller->id . '/qty';
/* @var $this yii\web\View */
/* @var $model app\models\RakitanT */
/* @var $form yii\widgets\ActiveForm */
/* $initialPreview = $model->url;
$initialPreviewConfig[] = array(
    'key' => $model->rakitan,
    'url' => 'index.php?r=rakitan/deletefile',
    'caption' => $model->nama_foto,
    'size' => $model->size,
); */

$dispOptions = ['class' => 'form-control'];
$saveOptions = [
    'type' => 'hidden', 
    'label'=>'', 
    'class' => 'form-control',
    'readonly' => true, 
    'tabindex' => 1000
];
$saveCont = ['class' => 'kv-saved-cont'];
?>

<?php $form = ActiveForm::begin([
    'id' => 'input-wo', 
    'enableAjaxValidation' => true
]); ?>

<div class="row">

    <?php
    echo '<div class="form-group">';
    echo '<label class="control-label">Kategori</label>';
    echo Select2::widget([
        'name' => 'kategori',
        'data' => ArrayHelper::map(KategoriT::find()->orderBy('kategori_nama ASC')->asArray()->all(), 'kategori', 'kategori_nama'),
        'options' => [
            'id' => 'kategori',
            'placeholder' => 'Pilih Kategori ...',
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => '#modal'
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
            'url' => Url::to(['/rakitan/smerek'])
        ],
    ]);
    ?>


    <?php
    /* echo '<label class="control-label">Produk</label>';
    echo DepDrop::widget([
        'name' => 'produk',
        'options' => ['id' => 'produk'],
        'pluginOptions' => [
            'depends' => ['merek'],
            'initialize' => true,
            'initDepends' => ['merek'],
            'params' => ['kategori'],
            //'placeholder'=> $model->IDJadwal,
            'url' => Url::to(['/rakitan/aproduk'])
        ],
    ]);
    echo '</div>'; */
    
    echo $form->field($model, 'produk')->widget(DepDrop::classname(), [
        //'data' => [$model->do_produk => $model->do_produk],
        'name' => 'produk',
        'options' => ['id' => 'produk'],
        'pluginOptions' => [
            'depends' => ['merek'],
            'initialize' => true,
            'initDepends' => ['merek'],
            'params' => ['kategori'],
            //'placeholder'=> $model->IDJadwal,
            'url' => Url::to(['/rakitan/aproduk'])
        ],
    ]);
    
    echo $form->field($model, 'do_produk')->widget(DepDrop::classname(), [
        'data' => [$model->do_produk => $model->do_produk],
        'name' => 'do_produk',
        'options' => ['id' => 'do_produk'],
        'pluginOptions' => [
            'depends' => ['produk'],
            'initialize' => true,
            'initDepends' => ['produk'],
            //'params' => ['kategori'],
            //'placeholder'=> $model->IDJadwal,
            'url' => Url::to(['/rakitan/sproduk'])
        ],
    ])->label('Produk *yg dapat di input yang diluar stok WO dan rakitan');
    ?>

    <?= $form->field($model, 'wo_jml')->textInput(['type' => 'number', 'min' => 1])->label('Jumlah masuk WO') ?>
    
    <?php
    // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
    // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
    // is disallowed.
    echo $form->field($model, 'wo_harga')->widget(NumberControl::classname(), [
        'maskedInputOptions' => [
            'prefix' => 'Rp. ',
            'groupSeparator' => '.',
            //'radixPoint' => ',',
            'digits' => 0,
            'allowMinus' => false
        ],
        'options' => $saveOptions,
        'displayOptions' => $dispOptions,
        'saveInputContainer' => $saveCont
    ]);
    ?>

</div>
<div class="list-group-item mt-2">
        <?= Html::submitButton('<i class="align-middle" data-feather="arrow-down-circle"></i> Input ke WO', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

<script>
    $(document).ready(function(){
        $('#do_produk').on('change', function(){
            var do_produk = $(this).val();
            $.ajax({
                type: "POST",
                url: '<?php echo $actionqty; ?>',
                data: {
                    do_produk: do_produk
                },
                dataType: "json",
                success: function(data) {
                    if(data.hasil == 'success'){
                        var el = document.getElementById('woprodukt-wo_jml');
                        el.setAttribute('max', data.jml_now);
                        $('#woprodukt-wo_jml').val(data.jml_now).trigger('change');
                        $('#woprodukt-wo_harga-disp').val(data.harga_jual).trigger('change');
                        $('#woprodukt-wo_harga').val(data.harga_jual).trigger('change');
                    }
                },
                error: function(er) {
                    params.error(er);
                }
            });
        });
    });
</script>
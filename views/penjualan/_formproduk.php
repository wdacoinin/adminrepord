<?php

use app\models\InventoriT;
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


$controller = Yii::$app->controller;
$actionqty = 'index.php?r=' . $controller->id . '/qty';

/* @var $this yii\web\View */
/* @var $model app\models\DoProdukT */
/* @var $form yii\widgets\ActiveForm */
/* $action = Url::to(['/do-produk/create']);
$actionback = Url::to(['/dop/update', 'do' => $model->do]); */

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
    'enableAjaxValidation' => false
    ]); ?>
<div class="col-md-12">



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
            'dropdownParent' => '#modal3'
        ],
    ]);
    ?>

    <?php
    echo '<label class="control-label">Merek</label>';
    echo DepDrop::widget([
        'name' => 'merek',
        'options'=>[
            'id' => 'merek',
            'placeholder' => 'Pilih'
        ],
        'type' => DepDrop::TYPE_SELECT2,
        'select2Options' => ['pluginOptions' => ['allowClear' => true, 'dropdownParent' => '#modal3']],
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
    echo '<label class="control-label">Produk</label>';
    echo DepDrop::widget([
        'name' => 'produk',
        'options' => ['id' => 'produk', 'placeholder' => 'Pilih'],
        'type' => DepDrop::TYPE_SELECT2,
        'select2Options' => ['pluginOptions' => ['allowClear' => true, 'dropdownParent' => '#modal3']],
        'pluginOptions' => [
            'depends' => ['merek'],
            'initialize' => true,
            'initDepends' => ['merek'],
            'params' => ['kategori'],
            //'placeholder'=> $model->IDJadwal,
            'url' => Url::to(['/rakitan/aproduk'])
        ],
    ]);
    echo '</div>';
    
    echo $form->field($model, 'do_produk')->widget(DepDrop::classname(), [
        'data' => [$model->do_produk => $model->do_produk],
        'name' => 'do_produk',
        'options' => ['id' => 'do_produk', 'placeholder' => 'Pilih'],
        'type' => DepDrop::TYPE_SELECT2,
        'select2Options' => ['pluginOptions' => ['allowClear' => true, 'dropdownParent' => '#modal3']],
        'pluginOptions' => [
            'depends' => ['produk'],
            'initialize' => true,
            'initDepends' => ['produk'],
            //'params' => ['kategori'],
            //'placeholder'=> $model->IDJadwal,
            'url' => Url::to(['/rakitan/sproduk'])
        ],
    ])->label('QTY Produk *yg dapat di input yang diluar stok rakitan dan retur');
    ?>

    <?= $form->field($model, 'penjualan_jml')->textInput(['type' => 'number', 'step' => 1, 'min' => 1]) ?>

    <?php
    // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
    // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
    // is disallowed.
    echo $form->field($model, 'penjualan_harga')->widget(NumberControl::classname(), [
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
<div class="list-group-item">
        <?= Html::submitButton('Input Produk', ['id' => 'sproduk', 'class' => 'btn btn-success']) ?>
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
                        var el = document.getElementById('penjualanprodukt-penjualan_jml');
                        el.setAttribute('max', data.jml_now);
                        $('#penjualanprodukt-penjualan_jml').val(data.jml_now).trigger('change');
                        $('#penjualanprodukt-penjualan_harga-disp').val(data.harga_jual).trigger('change');
                        $('#penjualanprodukt-penjualan_harga').val(data.harga_jual).trigger('change');
                    }
                },
                error: function(er) {
                    params.error(er);
                }
            });
        });
    });
</script>
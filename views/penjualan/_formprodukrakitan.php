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
use app\models\RakitanT;
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


    <?= // Usage with ActiveForm and model
    $form->field($model, 'rakitan')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(RakitanT::find()->select(["rakitan.rakitan", "CONCAT(inventori.kode, '-', rakitan.rakitan) AS kode"])->orderBy('rakitan.inventori ASC')
        ->join("LEFT JOIN", "inventori", "rakitan.inventori=inventori.inventori")
        ->where('rakitan.penjualan IS NULL')
        //->andWhere(['rakitan.id_user' => Yii::$app->user->identity->id])
        ->asArray()->all(), 'rakitan', 'kode'),
        'options' => ['placeholder' => 'Pilih'],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => '#modal3'
        ],
    ]);
    ?>

</div>
<div class="list-group-item">
        <?= Html::submitButton('Input Produk', ['id' => 'rakitanproduk', 'class' => 'btn btn-success']) ?>
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
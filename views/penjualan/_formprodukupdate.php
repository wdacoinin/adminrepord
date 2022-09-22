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
    if($sebatch == true){
        if($modProdukOrigin->do_produk_status == 1 && $modProdukOrigin->jml_now > 0){
            $stok = $modProdukOrigin->jml_now;
            $batch = $modProdukOrigin->produk . '-' . $modProdukOrigin->do_produk;
            echo '<div class="btn btn-sm btn-block btn-success mt-3 mb-3">Avalaible Stok di batch:' . $batch . ' Qty: ' . $stok . '</div>';
            echo $form->field($model, 'penjualan_jml')->textInput(['type' => 'number', 'step' => 1, 'min' => 1, 'max' => $stok + $model->penjualan_jml]);
        }else{
            if($modProdukOrigin != null){
                $stok = 0;
                $batch = $modProdukOrigin->produk . '-' . $modProdukOrigin->do_produk;
                echo '<div class="btn btn-sm btn-block btn-warning mt-3 mb-3">Avalaible Stok di batch:' . $batch . ' Qty: ' . $stok . '</div>';
                echo $form->field($model, 'penjualan_jml')->textInput(['type' => 'number', 'step' => 1, 'min' => 1, 'readonly' => true]);
            }else{
                echo '<div class="btn btn-sm btn-block btn-warning mt-3 mb-3">Avalaible Stok Kosong</div>';
            }
        }
    }else{
        if($modProdukOrigin != null){
            $stok = $modProdukOrigin->jml_now;
            $batch = $modProdukOrigin->produk . '-' . $modProdukOrigin->do_produk;
            echo '<div class="btn btn-sm btn-block btn-danger mt-3 mb-3">Avalaible Stok beda batch:' . $batch . ' Qty: ' . $stok . ', gunakan input baru!</div>';
        }else{
            echo '<div class="btn btn-sm btn-block btn-warning mt-3 mb-3">Avalaible Stok Kosong</div>';
        }
    }
    ?>

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
        <?= Html::submitButton('Update', ['id' => 'uproduk', 'class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

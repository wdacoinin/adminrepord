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
    'enableAjaxValidation' => true
    ]); ?>
<div class="col-md-12">



<?= // Usage with ActiveForm and model
$form->field($model, 'do_produk_status')->widget(Select2::classname(), [
    'data' => [3 => 'Retur', 4 => 'Retur Selesai Ganti Barang Sama', 5 => 'Retur Selesai Ganti Uang'],
    'options' => ['placeholder' => 'Pilih'],
    'pluginOptions' => [
        'allowClear' => true,
        'dropdownParent' => '#modal3'
    ],
])->label('Status Retur'); 
?>

</div>
<div class="list-group-item">
        <?= Html::submitButton('Update', ['id' => 'sproduk', 'class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
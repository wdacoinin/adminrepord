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
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\DoProdukT */
/* @var $form yii\widgets\ActiveForm */
/* $action = Url::to(['/do-produk/create']);
$actionback = Url::to(['/dop/update', 'do' => $model->do]); */
$initialPreview = $model->url;
$initialPreviewConfig[] = array(
    'key' => $model->rma_item,
    'url' => 'index.php?r=rma/deletefileproduk',
    'caption' => $model->nama_foto,
    'size' => $model->size,
);

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
    echo '<label class="control-label">Kategori</label>';
    echo Select2::widget([
        'name' => 'kategori',
        'data' => ArrayHelper::map(KategoriT::find()->orderBy('kategori_nama ASC')->asArray()->all(), 'kategori', 'kategori_nama'),
        'value' => $model->produk0->kategori,
        'options' => [
            'id' => 'kategori',
            'placeholder' => 'Pilih Kategori ...',
        ],
    ]);
    ?>
    <?= $form->field($model, 'produk')->textInput(['value' => $model->produk, 'id' => 'selproduk', 'name' => 'selproduk', 'hidden' => true])->label(false) ?>

    <?php

    echo $form->field($model, 'merek')->widget(DepDrop::classname(), [
        'data' => [$model->produk0->merek, $model->produk0->merek0->nama],
        'value' => $model->produk0->merek,
        'options' => ['id' => 'merek', 'value' => $model->produk0->merek],
        'pluginOptions' => [
            'depends' => ['kategori'],
            'initialize' => true,
            'initDepends' => ['kategori'],
            'params' => ['selproduk'],
            //'placeholder'=> $model->IDJadwal,
            'url' => Url::to(['/dopembelian/smerek'])
        ],
    ]);

    echo $form->field($model, 'produk')->widget(DepDrop::classname(), [
        'data' => ArrayHelper::map(ProdukT::find()->orderBy('nama ASC')->asArray()->all(), 'produk', 'nama'),
        'options' => ['id' => 'produk', 'value' => $model->produk],
        'pluginOptions' => [
            'depends' => ['merek'],
            'initialize' => true,
            'initDepends' => ['merek'],
            'params' => ['kategori'],
            //'placeholder'=> $model->IDJadwal,
            'url' => Url::to(['/dopembelian/sproduk'])
        ],
    ]);
    ?>

    <?= $form->field($model, 'rma_jml')->textInput(['type' => 'number', 'step' => 1, 'min' => 1]) ?>

    <?php
    // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
    // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
    // is disallowed.
    echo $form->field($model, 'rma_harga')->widget(NumberControl::classname(), [
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

    <?= $form->field($model, 'rma_ket')->textarea()->label('Keterangan') ?>

    <?php if($initialPreview != null){ ?>

    <?= $form->field($UpForm, 'file')->widget(FileInput::classname(), [
        'pluginOptions' => [
            'previewFileType' => 'any',
            'initialPreviewAsData'=>true,
            'initialPreview'=>$initialPreview,
            'initialCaption'=>true,
            'initialPreviewConfig' => $initialPreviewConfig,
            'overwriteInitial'=>false,
            'showPreview' => true,
            'showCaption' => true,
            'showRemove' => false,
            'showUpload' => false,
            'showFileInput' => false
        ],
    ]); ?>

    <?php }else{ ?>
        
    <?= $form->field($UpForm, 'file')->widget(FileInput::classname(), [
        'pluginOptions' => [
            'showPreview' => true,
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => false
        ],
    ]); ?>

    <?php } ?>

</div>
<div class="list-group-item">
        <?= Html::submitButton('Simpan Produk', ['id' => 'sproduk', 'class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php if($model->size > 0){ ?>
<style>	
	/* .displyFile .file-caption {
		display: none;
	} */
    /* .displyNota .kv-file-remove, */
    .fileinput-remove,
    #modal3 .file-caption {
		display: none;
	}
</style>
<?php } ?>
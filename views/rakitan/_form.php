<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\InventoriT;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\RakitanT */
/* @var $form yii\widgets\ActiveForm */
$initialPreview = $model->url;
$initialPreviewConfig[] = array(
    'key' => $model->rakitan,
    'url' => 'index.php?r=rakitan/deletefile',
    'caption' => $model->nama_foto,
    'size' => $model->size,
);
$today = date('Y-m-d');
?>


<?php $form = ActiveForm::begin(); ?>
<div class="col-md-12">

    <?= // Usage with ActiveForm and model
    $form->field($model, 'inventori')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(InventoriT::find()->where('lokasi = 1')->orderBy('kode')->asArray()->all(), 'inventori', 'kode'),
        'options' => ['placeholder' => 'Pilih'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <?php if($action > 0){?>
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
    <?php }else{?>
        
        <?= $form->field($UpForm, 'file')->widget(FileInput::classname(), [
            'pluginOptions' => [
                'showPreview' => true,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => false
            ],
        ]); ?>
    <?php }?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'rakitan_order')->widget(Select2::classname(), [
        'data' => [0 => 'Tidak', 1 => 'Ya'],
        'options' => ['placeholder' => 'By Order?'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <?=
    $form->field($model, 'rakitan_date')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Tgl.Penjualan', 'value' => $today],
        'pluginOptions' => [
            'todayHighlight' => true,
            'calendarWeeks' => true,
            //'daysOfWeekDisabled' => [0, 6],
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>


    <?= $form->field($model, 'status')->textInput(['hidden' => true])->label(false) ?>

    <?= $form->field($model, 'penjualan')->textInput(['hidden' => true])->label(false) ?>

</div>
<div class="list-group-item">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
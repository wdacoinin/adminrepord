<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;
use app\models\BackendUser;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\RakitanT */
/* @var $form yii\widgets\ActiveForm */
$initialPreview = $model->url;
$initialPreviewConfig[] = array(
    'key' => $model->pengiriman,
    'url' => 'index.php?r=pengiriman/deletefile',
    'caption' => $model->nama_foto,
    'size' => $model->size,
);
$today = date('Y-m-d H:i:s');

?>


<?php $form = ActiveForm::begin([
        'id' => 'update-gambar', 
        'enableAjaxValidation' => true]); ?>
<div class="col-md-12">

    <?= $form->field($model, 'surat_jalan')->textInput(['readonly' => true]) ?>

    <?=
    $form->field($model, 'datetime')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Tgl.Ambil/Kirim', 'value' => $today],
        'pluginOptions' => [
            'todayHighlight' => true,
            'calendarWeeks' => true,
            //'daysOfWeekDisabled' => [0, 6],
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>

    <?= // Usage with ActiveForm and model
    $form->field($model, 'user')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(BackendUser::find()->where('divisi > 1')->orderBy('nama')->asArray()->all(), 'id', 'nama'),
        'options' => ['placeholder' => 'Pilih'],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => '#modal'
        ],
    ]); 
    ?>

    <?= $form->field($model, 'nama_penerima')->textInput(['maxlength' => true])->label('Penerima / Pemberi Barang') ?>

    <?= $form->field($model, 'cp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

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
    

    <?= $form->field($model, 'lat')->textInput(['maxlength' => true, 'hidden' => true])->label(false) ?>

    <?= $form->field($model, 'lon')->textInput(['maxlength' => true, 'hidden' => true])->label(false) ?>

</div>
<div class="list-group-item">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

<script>
    
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
    $('#pengirimant-lat').val(position.coords.latitude);
    $('#pengirimant-lon').val(position.coords.longitude);
}

    $(document).ready(function(){
        $('#uploadform-file').on('click', function(){
            getLocation();
        });
    });
</script>
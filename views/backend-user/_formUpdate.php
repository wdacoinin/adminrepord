<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\Divisi;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\Modal;
use yii\helpers\Url;
use kartik\number\NumberControl;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\BackendUser */
/* @var $form yii\widgets\ActiveForm */
$initialPreview = $model->url;
$initialPreviewConfig[] = array(
    'key' => $model->id,
    'url' => 'index.php?r=backend-user/deletefile',
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
$modDivisi = ArrayHelper::map(Divisi::find()->asArray()->all(), 'divisi', 'nama');
?>

<div class="col-md-12">

    <?php $form = ActiveForm::begin(['id' => 'update', 'enableAjaxValidation' => true]); ?> 

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

    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['type' => 'hidden', 'value' => Yii::$app->user->identity->password])->label(false) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?php if(Yii::$app->user->identity->divisi == 1 ||  Yii::$app->user->identity->divisi == 2){ ?>
    <?= // Usage with ActiveForm and model
    $form->field($model, 'divisi')->widget(Select2::classname(), [
        'data' => $modDivisi,
        'options' => ['placeholder' => 'Pilih Divisi'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <?php
    // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
    // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
    // is disallowed.
    
            
    $tipe = Yii::$app->user->identity->divisi;
    $divisi = [1,2];
    //$admin = [2];
    if(in_array($tipe, $divisi) > 0){
        echo $form->field($model, 'gaji')->widget(NumberControl::classname(), [
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
    }
    ?>
    
    <?php }else{  ?>
    <?= // Usage with ActiveForm and model
    $form->field($model, 'divisi')->widget(Select2::classname(), [
        'data' => $modDivisi,
        'options' => ['placeholder' => 'Pilih Divisi'],
        'pluginOptions' => [
            'allowClear' => true
        ],
        'disabled' => true
    ]); 
    ?>
    <?php } ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

        <?php if(Yii::$app->user->identity->divisi == 1 ||  Yii::$app->user->identity->divisi == 2){ ?>
            <a class="btn btn-warning modalButton" value="<?= Url::to(['backend-user/change', 'id' => $model->id]) ?>"><i class="fas fa-key"></i> Ubah Password</a>
        <?php }else{ 
            if($model->id == Yii::$app->user->identity->id){?>
                <a class="btn btn-warning modalButton" value="<?= Url::to(['backend-user/change', 'id' => $model->id]) ?>"><i class="fas fa-key"></i> Ubah Password</a>
        <?php }
        } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<!----MODAL---------------->
<?php
    $js=<<<js
        $('.modalButton').click( function () {
            $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
        });
    js;
    $this->registerJs($js);
    Modal::begin([
        'title' => '<h2>Form</h2>',
        'id' => 'modal',
        'size' => 'modal-md',
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
?>
<!----END MODAL-------------->

<style>	
	.hide {
		display: none;
	}
	.alert,
	.alert .close{
		padding: .55rem;
	}
</style>
<?php if($model->size > 0){ ?>
<style>	
	/* .displyFile .file-caption {
		display: none;
	} */
    /* .displyNota .kv-file-remove, */
    .fileinput-remove,
    .file-caption {
		display: none;
	}
</style>
<?php } ?>
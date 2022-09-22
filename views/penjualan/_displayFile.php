<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\number\NumberControl;
use kartik\widgets\FileInput;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'File Nota';

//File Nota
$rows2 = (new \yii\db\Query())
->select([
    'doc_penj.id_img', 
    'doc_penj.penjualan', 
    'doc_penj.nama_foto', 
    'doc_penj.type', 
    'doc_penj.size', 
    'doc_penj.url'
    ])
->from('doc_penj')
->where(['penjualan' => $model->penjualan])
->all();

$initialPreview2 = [];
$initialPreviewConfig2 = [];
if($rows2){
foreach ($rows2 as $i => $row) {
    $initialPreview2[$i] = $row['url'];
    $initialPreviewConfig2[$i] = array(
        'key' => $row['id_img'],
        'url' => 'index.php?r=penjualan/deletefile',
        'caption' => $row['nama_foto'],
        'size' => $row['size'],
    );
}
}

?>

<?php if($rows2){ ?>

<div class="col-md-12 py-4 displyNota">

    <h4>File Nota</h4>

    <?php
    // Control display of widget elements
    echo FileInput::widget([
        'name' => 'attachment_2',
        'options'=>[
            'multiple'=>true
        ],
        'pluginOptions' => [
            'previewFileType' => 'any',
            'initialPreviewAsData'=>true,
            'initialPreview'=>$initialPreview2,
            'initialCaption'=>true,
            'initialPreviewConfig' => $initialPreviewConfig2,
            'overwriteInitial'=>false,
            'showPreview' => true,
            'showCaption' => true,
            'showRemove' => false,
            'showUpload' => false,
            'showFileInput' => false
        ]
    ]);
    ?>

</div>
<?php } ?>
<style>	
	/* .displyFile .file-caption {
		display: none;
	} */
    /* .displyNota .kv-file-remove, */
    .fileinput-remove,
    .displyNota .file-caption {
		display: none;
	}
</style>
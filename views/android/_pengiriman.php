<?php

use app\models\BackendUser;
use app\models\DoProdukT;
use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\bootstrap5\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'Ambil / Antar Barang';

//restrict action to user
$act = [];
if(isset($_GET['divisi']) && $_GET['divisi'] <= 2){
$act = [
    'class'=>'kartik\grid\ActionColumn',
    'width'=>'200px',
    'contentOptions' => [],
    'header'=>'Actions',
    'template' => '{delete}',
    'buttons'=>[
        'delete' => function($url, $model) { 
             if($model->pengiriman !== null){
             //diffrent controller
             $controller = Yii::$app->controller;
             //$arrayParams = ['pembelian_bahan' => $model->pembelian_bahan];
             //$params = array_merge(["{$controller->id}/update"], $arrayParams);
             $ud = 'index.php?r=' . $controller->id . '/delete&pengiriman=' . $model->pengiriman;
                 return '<a class="btn btn-light" href="'. $ud . '" title="Hapus" aria-label="Hapus" data-pjax="0" data-method="post" data-confirm="Hapus Pengiriman?"><i class="align-middle" data-feather="trash"></i> Hapus</a>';
             }else{
                 return null;
             }
         },

    ],
    'dropdown'=>false,
    'order'=>DynaGrid::ORDER_FIX_RIGHT
];
}else{
    $act = [];
}

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    /* [
        'label'=>'Gambar',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            return '<img src="'.$model->url.'" width="100" />';
        },
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'50px',
        'filter'=>false,
        'format'=>'raw'
    ], */
    [
        'attribute'=>'nama_penerima',
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filter'=>false,
    ],
    [
        'attribute'=>'cp',
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filter'=>false,
    ],
    [
        'attribute'=>'keterangan',
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filter'=>false,
    ],
    [
        'attribute'=>'Alamat',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            return $model->Alamat . '<br> <a target="_blank" class="btn btn-sm btn-primary" href="https://maps.google.com/maps?q='.$model->Alamat.'">Buka Maps</a>';
        },
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filter'=>false,
        'format'=>'raw'
    ],
    [
        'attribute'=>'surat_jalan',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            $controller = Yii::$app->controller;
            $ud = 'index.php?r=' . $controller->id . '/update&pengiriman=' . $model->pengiriman;
            $af = 'index.php?r=' . $controller->id . '/ambilfoto&pengiriman=' . $model->pengiriman;
            $ud2 = 'index.php?r=' . $controller->id . '/updategambar&pengiriman=' . $model->pengiriman . '&lat=' . $_GET['lat'] . '&lon=' . $_GET['lon'];
            if(isset($_GET['divisi']) && $_GET['divisi'] <= 2){
                return '<a class="btn btn-sm btn-secondary" href="'. $af . '"> <i class="align-middle" data-feather="image"></i> Ambil Foto</a>';
            }else{
                return '<a class="btn btn-sm btn-secondary" href="'. $af . '"> <i class="align-middle" data-feather="image"></i> Ambil Foto</a>';
            }
        },
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filter'=>false,
        'format'=>'raw'
    ],
    /* [
        'attribute'=>'datetime',
        'width'=>'150px',
        'options' => [
            'format' => 'YYYY-MM-DD',
        ],        
    ], */
];

if(isset($_GET['divisi']) && $_GET['divisi'] <= 3){
echo DynaGrid::widget([
    'columns' => $columns,
    'theme'=>'panel-info',
    'showPersonalize'=>false,
    'storage' => 'session',
    'gridOptions'=>[
        'dataProvider'=>$dataProvider,
        //'filterModel'=>$searchModel,
        'showPageSummary'=>false,
        'pageSummaryRowOptions'=>['class' => 'kv-page-summary table-light'],
        'floatHeader'=>false,
        'pjax'=>false,
        'responsiveWrap'=>true,
        'panel'=>[
            //'heading'=>'<h3 class="panel-title text-white"><i class="align-middle" data-feather="folder"></i>  Pengiriman</h3>',
            //'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah Pengiriman</em></div>',

            'footer' => false,
            'after' => false,
            'beforeOptions'=>['class'=>'grid_panel_remove'],
        ],
        'toolbar' =>  [
            /* ['content'=>
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ], */
            //['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            //'{export}',
            //'{toggleData}',
        ]
    ],
    'options'=>['id'=>'dynagrid-pengiriman'] // a unique identifier is important
]);
}
?>


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
        'title' => '<h2><i class="align-middle" data-feather="alert-circle"></i> </h2>',
        'id' => 'modal',
        'size' => 'modal-md',
    ]);
    echo "<div id='modalContent' class='p-0'></div>";
    Modal::end();
?>
<!----END MODAL-------------->


<style>	
	.hide {
		display: none;
	}
    .modal-body{
        padding: 0px !important;
    }
    .dropdown-menu.show{
        text-align: center !important;
    }
    .grid_panel_remove

{

    height:0px;

}
#dynagrid-pengiriman thead{
    display: none;
}
@media screen and (max-width: 480px){
.kv-table-wrap tr > td:first-child {
    margin-top: 0px !important;
}
}
</style>
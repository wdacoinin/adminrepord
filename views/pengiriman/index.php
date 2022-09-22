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
if(Yii::$app->user->identity->divisi < 2){
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
                 return '<a class="btn btn-light" target="_blank" href="'. $ud . '" title="Hapus" aria-label="Hapus" data-pjax="0" data-method="post" data-confirm="Hapus Pengiriman?"><i class="align-middle" data-feather="trash"></i> Hapus</a>';
             }else{
                 return null;
             }
         },

    ],
    'dropdown'=>false,
    'order'=>DynaGrid::ORDER_FIX_RIGHT
];
$loc = [
        'label'=>'Lokasi',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            if($model->lat != NULL){
            $ud = 'https://maps.google.com/?q=' . $model->lat . ', ' . $model->lon;
            return '<a class="btn btn-sm btn-primary" target="_blank" href="'. $ud . '"> <i class="align-middle" data-feather="edit"></i> Lokasi</a>';
            }else{
                return null;
            }
        },
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filter'=>true,
        'format'=>'raw'
];
}else{
    $act = [];
    $loc = [];
}

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'label'=>'Gambar',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            return '<img src="'.$model->url.'" width="100" />';
        },
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'50px',
        'filter'=>false,
        'format'=>'raw'
    ],
    [
        'attribute'=>'surat_jalan',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            $controller = Yii::$app->controller;
            $ud = 'index.php?r=' . $controller->id . '/update&pengiriman=' . $model->pengiriman;
            $ud2 = 'index.php?r=' . $controller->id . '/updategambar&pengiriman=' . $model->pengiriman;
            if(Yii::$app->user->identity->divisi <= 2){
            return '<a class="btn btn-sm btn-primary modalButton" value="'. $ud . '"> <i class="align-middle" data-feather="edit"></i> '. $model->surat_jalan. '</a>';
            }else{
                return '<a class="btn btn-sm btn-secondary modalButton" value="'. $ud2 . '"> <i class="align-middle" data-feather="image"></i> Update Gambar</a>';
            }
        },
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filter'=>true,
        'format'=>'raw'
    ],
    [
        'attribute'=>'nama_penerima',
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filter'=>true,
    ],
    [
        'attribute'=>'cp',
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filter'=>true,
    ],
    [
        'attribute'=>'Alamat',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            return $model->Alamat . '<br> <a target="_blank" class="btn btn-sm btn-primary" href="https://maps.google.com/maps?q='.$model->Alamat.'">Buka Maps</a>';
        },
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filter'=>true,
        'format'=>'raw'
    ],
    [
        'attribute'=>'datetime',
        'width'=>'150px',
        'options' => [
            'format' => 'YYYY-MM-DD',
            ],        
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => ([       
          'attribute' => 'datetime',
          'presetDropdown' => true,
          'convertFormat' => false,
          'pluginOptions' => [
            'separator' => ' - ',
            'format' => 'YYYY-MM-DD',
            'locale' => [
                  'format' => 'YYYY-MM-DD'
              ],
          ],
          'pluginEvents' => [
            "apply.daterangepicker" => "function() { apply_filter('datetime') }",
          ],
        ])
    ],
    [
        'label'=>'User',
        'attribute'=>'user0.nama',
        'value'=>'user0.nama',
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(BackendUser::find()->where('divisi > 1')->orderBy('nama')->asArray()->all(), 'id', 'nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Pilih'],
        'group'=>true,  // enable grouping
    ],
    $loc,
];
    
echo DynaGrid::widget([
    'columns' => $columns,
    'theme'=>'panel-info',
    'showPersonalize'=>true,
    'storage' => 'session',
    'gridOptions'=>[
        'dataProvider'=>$dataProvider,
        'filterModel'=>$searchModel,
        'showPageSummary'=>true,
        'pageSummaryRowOptions'=>['class' => 'kv-page-summary table-light'],
        'floatHeader'=>true,
        'pjax'=>false,
        'responsiveWrap'=>false,
        'panel'=>[
            'heading'=>'<h3 class="panel-title text-white"><i class="align-middle" data-feather="folder"></i>  Ambil / Antar Barang</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah Ambil / Antar Barang</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
            '<a class="btn btn-sm btn-success modalButton" value="'.Url::to(['create']).'"><i class="fas fa-plus"></i> Tambah Ambil / Antar</a>  ' .  
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
            '{toggleData}',
        ]
    ],
    'options'=>['id'=>'dynagrid-pengiriman'] // a unique identifier is important
]);
?>


<!----MODAL---------------->
<?php
    $js=<<<js
        $('.modalButton').click( function () {
            $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
        });
            
        $('#modal').on('hidden.bs.modal', function () {
        location.reload();
        });
        $('#modal').modal({
            backdrop: 'static',
            keyboard: false
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
</style>
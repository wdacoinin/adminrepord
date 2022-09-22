<?php

use app\models\DoProdukT;
use app\models\RmaItemT;
use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\bootstrap5\Modal;
use yii\helpers\Url;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'RMA';

//restrict action to user
$act = [];
if(Yii::$app->user->identity->divisi <= 2){
$act = [
    'class'=>'kartik\grid\ActionColumn',
    'width'=>'200px',
    'contentOptions' => [],
    'header'=>'Actions',
    'template' => '{delete}',
    'buttons'=>[
        'delete' => function($url, $model) { 
             if($model->rma !== null){
             //diffrent controller
             $controller = Yii::$app->controller;
             //$arrayParams = ['pembelian_bahan' => $model->pembelian_bahan];
             //$params = array_merge(["{$controller->id}/update"], $arrayParams);
             $ud = 'index.php?r=' . $controller->id . '/delete&rma=' . $model->rma;
                 return '<a class="btn btn-light" href="'. $ud . '" title="Hapus" aria-label="Hapus" data-pjax="0" data-method="post" data-confirm="Hapus WO?"><i class="align-middle" data-feather="trash"></i> Hapus</a>';
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
        'attribute'=>'rma',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            $controller = Yii::$app->controller;
            $ud = 'index.php?r=' . $controller->id . '/update&rma=' . $model->rma;
            //$ud2 = 'index.php?r=' . $controller->id . '/updategambar&rma=' . $model->rma;
            return '<a class="btn btn-sm btn-primary" href="'. $ud . '"> <i class="align-middle" data-feather="edit"></i>'.'RMA-'. $model->rma. '</a>';
        },
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filter'=>true,
        'format'=>'raw'
    ],
    [
        'label'=>'Item',
        'value'=>function ($model, $key, $index, $widget) {
            $modproduk = RmaItemT::find()
            ->select(["GROUP_CONCAT(kategori.kategori_nama, ' : ', produk.nama, ' qty:', rma_item.rma_jml SEPARATOR '<br>') AS item"])
            ->join("LEFT JOIN", "produk", "rma_item.produk=produk.produk")
            ->join("LEFT JOIN", "kategori", "produk.kategori=kategori.kategori")
            ->where(['rma_item.rma' => $model->rma])
            ->orderBy('kategori.kategori_urutan ASC')
            ->asArray()->all();
            if($modproduk != null){
                $item = [];
                foreach ($modproduk as $item){
                    //$item[] = array($item['item']);
                    return '<div class="list-group-item">' . $item['item'] . '</div>';
                }
                 //json_encode($item);
            }
        },
        'hAlign'=>'left', 
        'vAlign'=>'middle',
        'width'=>'450px',
        'filter'=>false,
        'format'=>'raw'
    ],
    [
        'attribute'=>'rma_date',
        'width'=>'150px',
        'options' => [
            'format' => 'YYYY-MM-DD',
            ],        
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => ([       
          'attribute' => 'rma_date',
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
            "apply.daterangepicker" => "function() { apply_filter('rma_date') }",
          ],
        ])
    ],
    [
        'attribute'=>'rma_status',
        'hAlign'=>'left', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>['Proses' => 'Proses', 'Selesai' => 'Selesai'], 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Pilih'],
        'group'=>true,  // enable grouping
    ],
    [
        'attribute'=>'id_user',
        'value'=>'user.nama',
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'filter'=>true,
        'group'=>true,  // enable grouping
    ],
    [
        'attribute'=>'konsumen',
        'value' => 'konsumen0.konsumen_nama',
        'hAlign'=>'left', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filter'=>true,
    ],
    $act
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
            'heading'=>'<h3 class="panel-title text-white"><i class="align-middle" data-feather="folder"></i>  RMA</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah RMA</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
            '<a class="btn btn-sm btn-success modalButton" value="'.Url::to(['create']).'"><i class="fas fa-plus"></i> Tambah RMA</a>  ' .  
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
            '{toggleData}',
        ]
    ],
    'options'=>['id'=>'dynagrid-rma'] // a unique identifier is important
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
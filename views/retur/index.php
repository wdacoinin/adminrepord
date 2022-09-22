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
$this->title = 'Retur';

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
             if($model->retur !== null){
             //diffrent controller
             $controller = Yii::$app->controller;
             //$arrayParams = ['pembelian_bahan' => $model->pembelian_bahan];
             //$params = array_merge(["{$controller->id}/update"], $arrayParams);
             $ud = 'index.php?r=' . $controller->id . '/delete&retur=' . $model->retur;
                 return '<a class="btn btn-light" href="'. $ud . '" title="Hapus" aria-label="Hapus" data-pjax="0" data-method="post" data-confirm="Hapus Retur?"><i class="align-middle" data-feather="trash"></i> Hapus</a>';
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
        'attribute'=>'inventori',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            $controller = Yii::$app->controller;
            $ud = 'index.php?r=' . $controller->id . '/update&retur=' . $model->retur;
            $ud2 = 'index.php?r=' . $controller->id . '/updategambar&retur=' . $model->retur;
            return '<a class="btn btn-sm btn-primary" href="'. $ud . '"> <i class="align-middle" data-feather="edit"></i> '. $model->noretur. '</a>
             <a class="btn btn-sm btn-secondary modalButton" value="'. $ud2 . '"> <i class="align-middle" data-feather="image"></i> Update Gambar</a>';
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
            $modproduk = DoProdukT::find()
            ->select(["GROUP_CONCAT(kategori.kategori_nama, ' : ', produk.nama, ' qty:', do_produk.do_jml SEPARATOR '<br>') AS item"])
            ->join("LEFT JOIN", "produk", "do_produk.produk=produk.produk")
            ->join("LEFT JOIN", "kategori", "produk.kategori=kategori.kategori")
            ->where(['do_produk.retur' => $model->retur])
            //->groupBy('do_produk.retur')
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
        'attribute'=>'do',
        'value'=>'do0.faktur',
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filter'=>false,
    ],
    [
        'attribute'=>'date',
        'width'=>'150px',
        'options' => [
            'format' => 'YYYY-MM-DD',
            ],        
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => ([       
          'attribute' => 'date',
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
            "apply.daterangepicker" => "function() { apply_filter('date') }",
          ],
        ])
    ],
    [
        'attribute'=>'retur_status',
        'value'=>function ($model, $key, $index, $widget) {
            if($model->retur_status == 1){
                return 'Proses';
            }elseif($model->retur_status == 2){
                return 'Selesai Replace barang beda';
            }elseif($model->retur_status == 3){
                return 'Selesai diganti uang';
            }else{
                return 'Selesai replace barang identik';
            }
        },
        'hAlign'=>'left', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>[1 => 'Proses', 2 => 'Selesai Replace barang beda', 3 => 'Selesai diganti uang', 4 => 'Selesai replace barang identik'], 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Pilih'],
        'format'=>'raw',
        'group'=>true,  // enable grouping
        'format'=>'raw'
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
    [
        'label' => 'Harga Jual',
        'attribute'=>'harga_jual', 
        'value'=>function ($model, $key, $index, $widget) {
            $modhj = DoProdukT::find()->select('SUM(do_jml*harga_jual) AS harga_jual')->where(['retur' => $model->retur])
            ->groupBy('retur')
            ->asArray()->one();
            
            if($modhj != null){
                return (int) round($modhj['harga_jual'],0);
            }
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>true
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
            'heading'=>'<h3 class="panel-title text-white"><i class="align-middle" data-feather="folder"></i>  Retur</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah Retur</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
            '<a class="btn btn-sm btn-success modalButton" value="'.Url::to(['create']).'"><i class="fas fa-plus"></i> Tambah Retur</a>  ' .  
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
            '{toggleData}',
        ]
    ],
    'options'=>['id'=>'dynagrid-retur'] // a unique identifier is important
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
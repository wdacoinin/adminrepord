<?php

use app\models\DoProdukT;
use app\models\Penjualan;
use app\models\PenjualanT;
use app\models\WoProdukT;
use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\bootstrap5\Modal;
use yii\helpers\Url;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'Working Order';

//restrict action to user
$act = [];
if(Yii::$app->user->identity->divisi <= 3){
$act = [
    'class'=>'kartik\grid\ActionColumn',
    'width'=>'200px',
    'contentOptions' => [],
    'header'=>'Actions',
    'template' => '{delete}',
    'buttons'=>[
        'delete' => function($url, $model) { 
             if($model->wo !== null){
             //diffrent controller
             $controller = Yii::$app->controller;
             //$arrayParams = ['pembelian_bahan' => $model->pembelian_bahan];
             //$params = array_merge(["{$controller->id}/update"], $arrayParams);
             $ud = 'index.php?r=' . $controller->id . '/delete&wo=' . $model->wo;
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
        'attribute'=>'WO',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            $controller = Yii::$app->controller;
            $ud = 'index.php?r=' . $controller->id . '/update&wo=' . $model->wo;
            return '<a class="btn btn-sm btn-primary" href="'. $ud . '"> <i class="align-middle" data-feather="edit"></i> WO-'. $model->wo. '</a>';
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
            $modproduk = WoProdukT::find()
            ->select(["GROUP_CONCAT(kategori.kategori_nama, ' : ', produk.nama, ', Status:', wo_produk.wo_produk_status, ', qty:', wo_produk.wo_jml SEPARATOR '<br>') AS item"])
            ->join("LEFT JOIN", "produk", "wo_produk.produk=produk.produk")
            ->join("LEFT JOIN", "kategori", "produk.kategori=kategori.kategori")
            ->where(['wo_produk.wo' => $model->wo])
            //->groupBy('do_produk.wo')
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
        'attribute'=>'penjualan',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            $controller = Yii::$app->controller;
            $ud = 'index.php?r=penjualan/update&penjualan=' . $model->penjualan;
            $Penj = PenjualanT::findOne($model->penjualan);
            if($Penj != null){
                return '<a class="btn btn-sm btn-primary" href="'. $ud . '">'. $Penj->faktur. '</a>';
            }else{
                return 'Belum masuk penjualan';
            }
        },
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filter'=>false,
    ],
    [
        'attribute'=>'status',
        'hAlign'=>'left', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>['Start' => 'Start', 'Perakitan' => 'Perakitan', 'Install' => 'Install', 'Order Produk' => 'Order Produk', 'Selesai' => 'Selesai'], 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Pilih'],
        'format'=>'raw',
        'group'=>true,  // enable grouping
        'format'=>'raw'
    ],
    [
        'attribute'=>'user',
        'value'=>'user.nama',
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'filter'=>true,
        'group'=>true,  // enable grouping
    ],
    [
        'attribute'=>'konsumen',
        'value'=>'konsumen0.konsumen_nama',
        'hAlign'=>'left', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filter'=>false,
    ],
    [
        'attribute'=>'Harga', 
        'value'=>function ($model, $key, $index, $widget) {
            $modhj = WoProdukT::find()->select('SUM(wo_jml*wo_harga) AS harga_jual')->where(['wo' => $model->wo])
            ->groupBy('wo')
            ->asArray()->one();
            
            if($modhj != null){
                return $modhj['harga_jual'];
            }else{
                return 0;
            }
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
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
            'heading'=>'<h3 class="panel-title text-white"><i class="align-middle" data-feather="folder"></i>  Working Order</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah Working Order</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
            '<a class="btn btn-sm btn-success modalButton" value="'.Url::to(['create']).'"><i class="fas fa-plus"></i> Tambah Working Order</a>  ' .  
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
            '{toggleData}',
        ]
    ],
    'options'=>['id'=>'dynagrid-wo'] // a unique identifier is important
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
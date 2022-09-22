<?php

use app\models\PenjualanProdukTtT;
use app\models\Penjualanv;
use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\bootstrap5\Modal;
use yii\helpers\Url;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'Penjualan';

//restrict action to user
$act = [];
if(Yii::$app->user->identity->divisi <= 2){
$act = [
    'class'=>'kartik\grid\ActionColumn',
    'width'=>'50px',
    'contentOptions' => [],
    'header'=>'Actions',
    'template' => '{delete}',
    'buttons'=>[
        'delete' => function($url, $model) { 
             if($model->penjualan !== null){
             //diffrent controller
             $controller = Yii::$app->controller;
             //$arrayParams = ['pembelian_bahan' => $model->pembelian_bahan];
             //$params = array_merge(["{$controller->id}/update"], $arrayParams);
             $ud = 'index.php?r=' . $controller->id . '/delete&penjualan=' . $model->penjualan;
                 return '<a class="btn btn-light" href="'. $ud . '" title="Hapus" aria-label="Hapus" data-pjax="0" data-method="post" data-confirm="Hapus Penjualan?"><i class="align-middle" data-feather="trash"></i> Hapus</a>';
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
        'attribute'=>'faktur',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            $controller = Yii::$app->controller;
            $ud = 'index.php?r=' . $controller->id . '/update&penjualan=' . $model->penjualan;
            /* $ud2 = 'index.php?r=' . $controller->id . '/updategambar&penjualan=' . $model->penjualan; */
            return '<a class="btn btn-sm btn-primary" href="'. $ud . '"> <i class="align-middle" data-feather="edit"></i> '. $model->faktur. '</a>';
        },
        'hAlign'=>'left', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'filter'=>true,
        'format'=>'raw'
    ],
    [
        'attribute'=>'penjualan_tgl',
        'width'=>'150px',
        'options' => [
            'format' => 'YYYY-MM-DD',
            ],        
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => ([       
          'attribute' => 'penjualan_tgl',
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
            "apply.daterangepicker" => "function() { apply_filter('penjualan_tgl') }",
          ],
        ])
    ],
    [
        'attribute'=>'penjualan_status',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            $cpembayaran = Penjualanv::findOne($model->penjualan);
            if( $cpembayaran->total_plus_ppn > 0 ){ $max = $cpembayaran->total_plus_ppn; } else { $max = 0; }
            //get total bayar jika ada
            if( $cpembayaran->total_bayar > 0 ){ $total_bayar =$cpembayaran->total_bayar; } else { $total_bayar = 0; }
            //kekurangan
            $kkurang = $max - $total_bayar;
            //get tt
            $modPenjTT = PenjualanProdukTtT::find()->select('SUM(do_jml*do_hpp) AS totaltt')->where(['penjualan' => $model->penjualan])->asArray()->one();
            if($modPenjTT != null){
                $totaltt = (int) $modPenjTT['totaltt'];
                $kurang = $kkurang - $totaltt;
            }else{
                $kurang = $kkurang;
            }
            if($kurang > 0){
                return 'Piutang';
            }else{
                return 'Lunas';
            }
            
        },
        'hAlign'=>'left', 
        'vAlign'=>'top',
        'width'=>'80px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>['Lunas' => 'Lunas', 'Piutang' => 'Piutang'], 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Pilih'],
        'group'=>true,  // enable grouping
    ],
    [
        'attribute'=>'konsumen_nama',
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'120px',
        'filter'=>true,
    ],
    [
        'attribute'=>'penjualan_type',
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'filter'=>false,
    ],
    [
        'attribute'=>'sales',
        'value'=>'sales',
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'120px',
        'filter'=>true,
        'group'=>true,  // enable grouping
    ],
    [
        'attribute'=>'penjualan_diskon', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'total', 
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            $modPenjTT = PenjualanProdukTtT::find()->select('SUM(do_jml*do_hpp) AS totaltt')->where(['penjualan' => $model->penjualan])->asArray()->one();
            if($modPenjTT != null){
                $totaltt = (int) $modPenjTT['totaltt'];
                return $model->total - $totaltt;
            }else{
                return $model->total;
            }
            
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'ppn', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'total_plus_ppn',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            $modPenjTT = PenjualanProdukTtT::find()->select('SUM(do_jml*do_hpp) AS totaltt')->where(['penjualan' => $model->penjualan])->asArray()->one();
            if($modPenjTT != null){
                $totaltt = (int) $modPenjTT['totaltt'];
                return $model->total_plus_ppn - $totaltt;
            }else{
                return $model->total_plus_ppn;
            }
            
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'total_bayar',
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 2],
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
        'floatHeader' => true, // table header floats when you scroll
        'bordered' => true,
        'striped' => false,
        'condensed' => true,
        'hover' => true,
        'panel'=>[
            'heading'=>'<h3 class="panel-title text-white"><i class="align-middle" data-feather="folder"></i>  Penjualan</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah Penjualan</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
            '<a class="btn btn-sm btn-success modalButton" value="'.Url::to(['create']).'"><i class="fas fa-plus"></i> Tambah Penjualan</a>  ' .  
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
            '{toggleData}',
        ]
    ],
    'options'=>['id'=>'dynagrid-penjualan'] // a unique identifier is important
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

<?php
$device = Yii::$app->params['devicedetect'];
if($device['isDesktop'] == true){?>
<script async='async' type='text/javascript'>
    $(document).ready(function() {

    var element2, name2, arr2;
    element2 = document.getElementById("sidebar");
    name2 = "collapsed";
    arr2 = element2.className.split(" ");
    if (arr2.indexOf(name2) == -1) {
        element2.className += " " + name2;
    }
        
    });
</script>
<?php } ?>

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
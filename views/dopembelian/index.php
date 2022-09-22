<?php

use app\models\Dopembelianv;
use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\bootstrap5\Modal;
use yii\helpers\Url;
use app\models\SupplierT;
use app\models\MerekT;
use yii\helpers\ArrayHelper;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'DO Pembelian';

//restrict action to user
$act = [];
if(Yii::$app->user->identity->divisi <= 2){
$act = [
    'class'=>'kartik\grid\ActionColumn',
    'width'=>'100px',
    'hAlign'=>'center', 
    'contentOptions' => [],
    'header'=>'Actions',
    'template' => '{delete}',
    'dropdown'=>false,
    'order'=>DynaGrid::ORDER_FIX_RIGHT
];
}else{
    $act = [];
}

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'attribute'=>'do',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            $controller = Yii::$app->controller;
            $ud = 'index.php?r=dopembelian/update&do=' . $model->do;
            return '<a class="btn btn-sm btn-primary" href="'. $ud . '">'. $model->faktur. '</a>';
        },
        'hAlign'=>'left', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filter'=>true,
        'format'=>'raw'
    ],
    [
        'attribute'=>'no_sj', 
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'filter'=>true
    ],
    [
        'attribute'=>'do_tgl',
        'width'=>'150px',
        'options' => [
            'format' => 'YYYY-MM-DD',
            ],        
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => ([       
          'attribute' => 'do_tgl',
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
            "apply.daterangepicker" => "function() { apply_filter('do_tgl') }",
          ],
        ])
    ],
    [
        'attribute'=>'do_tempo',
        'width'=>'150px',
        'options' => [
            'format' => 'YYYY-MM-DD',
            ],        
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => ([       
          'attribute' => 'do_tempo',
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
            "apply.daterangepicker" => "function() { apply_filter('do_tempo') }",
          ],
        ])
    ],
    [
        'attribute'=>'supplier_nama',
        /* 'value'=>'supplier_nama', */
        'hAlign'=>'left', 
        'vAlign'=>'top',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(SupplierT::find()->orderBy('supplier_nama')->asArray()->all(), 'supplier_nama', 'supplier_nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Pilih'],
        'group'=>true,  // enable grouping
    ],
    [
        'attribute'=>'do_status',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            //get nilai pembelian
            $modDo = Dopembelianv::findOne($model->do);
            if( $modDo->total_plus_ppn > 0 ){ $max = $modDo->total_plus_ppn; } else { $max = 0; }
            //get total bayar jika ada
            if( $modDo->total_bayar > 0 ){ $total_bayar =$modDo->total_bayar; } else { $total_bayar = 0; }
            //kekurangan
            $kurang = $max - $total_bayar;
            
            if($kurang > 0){
                return 'Hutang';
            }else{
                return 'Lunas';
            }
        },
        'hAlign'=>'left', 
        'vAlign'=>'top',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> ['Hutang' => 'Hutang', 'Lunas' => 'Lunas', 'TT' => 'Tukar Tambah', 'Konsinyasi' => 'Konsinyasi'], 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Pilih'],
        'group'=>true,  // enable grouping
    ],
    [
        'attribute'=>'do_diskon', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'total', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'ppn', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'total_plus_ppn',
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'total_bayar',
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'label'=>'Hutang',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            if($model->total_plus_ppn > $model->total_bayar){
                return $model->total_plus_ppn - $model->total_bayar;
            }else{
                return 0;
            }
            
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
    ],
    //$act,
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
            'heading'=>'<h3 class="panel-title text-white"><i class="align-middle" data-feather="shopping-bag"></i> DO Pembelian</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah untuk buat DO</em></div>',
            'after' => false
        ],
        'rowOptions'=>function($model){
            
            //get nilai pembelian
            $modDo = Dopembelianv::findOne($model->do);
            if( $modDo->total_plus_ppn > 0 ){ $max = $modDo->total_plus_ppn; } else { $max = 0; }
            //get total bayar jika ada
            if( $modDo->total_bayar > 0 ){ $total_bayar =$modDo->total_bayar; } else { $total_bayar = 0; }
            //kekurangan
            $kurang = $max - $total_bayar;

            $today = date('Y-m-d');
            $tempominsem = date('Y-m-d', strtotime('-7 day', strtotime($model->do_tempo)));
            if($model->do_tempo != NULL){
                if($kurang > 0 && $tempominsem <= $today && $model->do_tempo >= $today){
                    return ['class' => 'bg-warning text-black'];
                }elseif($kurang > 0 && $model->do_tempo < $today){
                    return ['class' => 'bg-danger text-black'];
                }
            }
        },
        'toolbar' =>  [
            ['content'=>
            '<a class="btn btn-sm btn-success modalButton" value="'.Url::to(['dop/create']).'"><i class="fas fa-plus"></i> Tambah DO</a>  ' . 
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
            '{toggleData}',
        ]
    ],
    'options'=>['id'=>'dynagrid-do'] // a unique identifier is important
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
        'size' => 'modal-lg',
    ]);
    echo "<div id='modalContent' class='p-0'></div>";
    Modal::end();
?>
<!----END MODAL-------------->

<!----MODAL XL---------------->
<?php
    $js=<<<js
        $('.modalButton2').click( function () {
            $('#modal2').modal('show')
                    .find('#modalContent2')
                    .load($(this).attr('value'));
        });
        $('#modal2').modal({
            backdrop: 'static',
            keyboard: false
         });
    js;
    $this->registerJs($js);
    Modal::begin([
        'title' => '<h2><i class="align-middle" data-feather="alert-circle"></i> </h2>',
        'id' => 'modal2',
        'size' => 'modal-xl modal-dialog-centered modal-dialog-scrollable',
    ]);
    echo "<div id='modalContent2' class='p-0'></div>";
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
	
    /* .modal-body{
        padding: 0px !important;
    } */
    .dropdown-menu.show{
        text-align: center !important;
    }
</style>
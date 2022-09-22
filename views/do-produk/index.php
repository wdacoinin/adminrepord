<?php

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
$do = $do;
$this->title = 'List Produk';

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'attribute'=>'produk',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            $controller = Yii::$app->controller;
            $ud = 'index.php?r=do-produk/update&do_produk=' . $model->do_produk;
            return '<a class="btn btn-sm btn-primary modalButton3" value="'. $ud . '">'. $model->produk0->nama. '</a>';
        },
        'hAlign'=>'left', 
        'vAlign'=>'middle',
        'width'=>'200px',
        'filter'=>true,
        'format'=>'raw'
    ],
    [
        'attribute'=>'do_jml', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'harga_jual', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'label'=>'Subtotal', 
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            return $model->do_jml*$model->harga_jual;
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'class'=>'kartik\grid\ActionColumn',
        'width'=>'100px',
        'hAlign'=>'center', 
        'contentOptions' => [],
        'header'=>'Actions',
        'template' => '{delete}',
        'buttons'=>[
            'delete' => function($url, $model) { 
                 if($model->do_produk !== null){

                 $ud = 'index.php?r=do-produk/delete&do_produk=' . $model->do_produk;
                     return '<div class="d-grid gap-0"><a class="btn btn-light" value="'. $ud . '"><i class="align-middle" data-feather="trash"></i> Hapus</a></div>';
                 }else{
                     return null;
                 }
             },
        ],
        'dropdown'=>false,
        'order'=>DynaGrid::ORDER_FIX_RIGHT
    ],
];
echo DynaGrid::widget([
    'columns' => $columns,
    'theme'=>'panel-info',
    'showPersonalize'=>false,
    'storage' => 'session',
    'gridOptions'=>[
        'dataProvider'=>$dataProvider,
        //'filterModel'=>$searchModel,
        'showPageSummary'=>true,
        'pageSummaryRowOptions'=>['class' => 'kv-page-summary table-light'],
        'floatHeader'=>true,
        'pjax'=>true,
        'responsiveWrap'=>false,
        'panel'=>[
            //'heading'=>'<h3 class="panel-title text-white"><i class="align-middle" data-feather="shopping-bag"></i> List Produk</h3>',
            //'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah untuk buat DO Produk</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
            '<a class="btn btn-sm btn-success modalButton3" value="'.Url::to(['dopembelian/createproduk', 'do' => $do]).'"><i class="fas fa-plus"></i> Tambah DO Produk</a>'
            ],
            //['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            //'{export}',
            //'{toggleData}',
        ]
    ],
    'options'=>['id'=>'dynagrid-do_produk'] // a unique identifier is important
]);
?>
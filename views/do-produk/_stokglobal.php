<?php

use app\models\DoProdukT;
use app\models\InventoriT;
use app\models\KategoriT;
use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\bootstrap5\Modal;
use yii\helpers\Url;
use app\models\SupplierT;
use app\models\MerekT;
use app\models\ProdukT;
use app\models\StokJenisT;
use yii\helpers\ArrayHelper;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
//$do = $do;
$this->title = 'Global Stok';

$margin = [];
if(Yii::$app->user->identity->divisi < 2){
$margin = [
    'label' => 'Margin',
    'value'=>function ($model, $key, $index, $widget) { //diffrent controller
        if($model->do_produk_origin == 0){
            $returcount = DoProdukT::find()->where(['do_produk_origin' => $model->do_produk])->andWhere('retur > 0 AND jml_now > 0')->count();
            if($returcount > 0){
                $stokorigin = DoProdukT::find()->select('SUM(jml_now) AS jml_now')->where(['do_produk_origin' => $model->do_produk])->andWhere('retur > 0 AND jml_now > 0')->asArray()->one();
                if($stokorigin != NULL && $stokorigin['jml_now'] > 0){
                    $jml_now = $model->jml_now - (int) $stokorigin['jml_now'];
                }else{
                    $jml_now = $model->jml_now;
                }
            }else{
                $jml_now = $model->jml_now;
            }
        }else{
            $jml_now = $model->jml_now;
        }

        $hpp = $jml_now*$model->do_harga;
        $val = $jml_now*$model->harga_jual;
        $mrg = $val - $hpp;
        return $mrg;
    },
    'hAlign'=>'right', 
    'vAlign'=>'middle',
    'width'=>'80px',
    'format'=>['decimal', 2],
    'pageSummary'=>true,
    'filter'=>false
];
}else{
    $margin = [];
}

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'label'=>'Img',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            if($model->do_produk_origin > 0){
                $modProdO = DoProdukT::findOne($model->do_produk_origin);
                return '<img src="'.$modProdO->url.'" width="80" />';
            }else{
                return '<img src="'.$model->url.'" width="80" />';
            }
            
        },
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'50px',
        'format'=>'raw'
    ],
    [
        'label' => 'Batch',
        'attribute'=>'batch', 
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            $controller = Yii::$app->controller;
            $ud = 'index.php?r=dopembelian/update&do=' . $model->do0->do;
            if($model->do_produk_origin > 0){
                return '<a class="btn btn-sm btn-primary btn-block" href="'. $ud . '">'. $model->produk . '-' . $model->do_produk_origin. '</a>';
            }else{
                return '<a class="btn btn-sm btn-primary btn-block" href="'. $ud . '">'. $model->produk . '-' . $model->do_produk. '</a>';
            }
        },
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'format'=>'raw',
        'filter'=>true
    ],
    [
        'label' => 'Tgl Stok',
        'attribute'=>'do_produk_date', 
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'50px',
        'group'=>true,  // enable grouping,
        'filter'=>false
    ],
    [
        'attribute'=>'produk',
        'contentOptions' => ['style' => 'font-size:10px;!important'],
        'value'=>'produk0.nama',
        'hAlign'=>'left', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(ProdukT::find()->orderBy('nama')->asArray()->all(), 'produk', 'nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Pilih'],
        'group'=>true,  // enable grouping
    ],
    [
        'attribute'=>'stok_jenis',
        'value'=>'stokJenis.stok_jenis_nama',
        'hAlign'=>'left', 
        'vAlign'=>'middle',
        'width'=>'50px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(StokJenisT::find()->orderBy('stok_jenis_nama ASC')->asArray()->all(), 'stok_jenis', 'stok_jenis_nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Pilih'],
    ],
    [
        'attribute'=>'kategori_nama',
        'contentOptions' => ['style' => 'font-size:10px;!important'],
        'value'=>'kategori_nama',
        'hAlign'=>'left', 
        'vAlign'=>'middle',
        'width'=>'50px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(KategoriT::find()->orderBy('kategori_nama')->asArray()->all(), 'kategori_nama', 'kategori_nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Pilih'],
    ],
    [
        'attribute'=>'merek_nama',
        'contentOptions' => ['style' => 'font-size:10px;!important'],
        'value'=>'merek_nama',
        'hAlign'=>'left', 
        'vAlign'=>'middle',
        'width'=>'70px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(MerekT::find()->orderBy('nama')->asArray()->all(), 'nama', 'nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Pilih'],
    ],
    [
        'label' => 'Lokasi',
        'attribute'=>'inventori',
        'contentOptions' => ['style' => 'font-size:10px;!important'],
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            if($model->rakitan > 0){
                return $model->inventori0->kode . '-' . $model->rakitan;
            }else{
                return $model->inventori0->kode;
            }
        },
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'50px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(InventoriT::find()->orderBy('kode')->asArray()->all(), 'inventori', 'kode'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Pilih'],
        'pageSummary'=>false,
        'group'=>true,  // enable grouping
    ],
    [
        'label' => 'Stok',
        'attribute'=>'jml_now', 
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            if($model->do_produk_origin == 0){
                $returcount = DoProdukT::find()->where(['do_produk_origin' => $model->do_produk])->andWhere('retur > 0 AND jml_now > 0')->count();
                if($returcount > 0){
                    $stokorigin = DoProdukT::find()->select('SUM(jml_now) AS jml_now')->where(['do_produk_origin' => $model->do_produk])->andWhere('retur > 0 AND jml_now > 0')->asArray()->one();
                    if($stokorigin != NULL && $stokorigin['jml_now'] > 0){
                        return $model->jml_now - (int) $stokorigin['jml_now'];
                    }else{
                        return $model->jml_now;
                    }
                }else{
                    return $model->jml_now;
                }
            }else{
                return $model->jml_now;
            }
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'10px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'label' => 'HPP',
        'attribute'=>'do_harga', 
        'contentOptions' => ['style' => 'font-size:10px;!important'],
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'20px',
        'format'=>['decimal', 2],
        'pageSummary'=>false,
        'filter'=>false
    ],
    [
        'attribute'=>'harga_jual', 
        'contentOptions' => ['style' => 'font-size:10px;!important'],
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'20px',
        'format'=>['decimal', 2],
        'pageSummary'=>false,
        'filter'=>false
    ],
    [
        'label'=>'Value', 
        'contentOptions' => ['style' => 'font-size:10px;!important'],
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            if($model->do_produk_origin == 0){
                $returcount = DoProdukT::find()->where(['do_produk_origin' => $model->do_produk])->andWhere('retur > 0 AND jml_now > 0')->count();
                if($returcount > 0){
                    $stokorigin = DoProdukT::find()->select('SUM(jml_now) AS jml_now')->where(['do_produk_origin' => $model->do_produk])->andWhere('retur > 0 AND jml_now > 0')->asArray()->one();
                    if($stokorigin != NULL && $stokorigin['jml_now'] > 0){
                        $jml_now = $model->jml_now - (int) $stokorigin['jml_now'];
                    }else{
                        $jml_now = $model->jml_now;
                    }
                }else{
                    $jml_now = $model->jml_now;
                }
            }else{
                $jml_now = $model->jml_now;
            }
            return $jml_now*$model->do_harga;
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'20px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
    ],
    $margin,
    /* [
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
    ], */
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
            'heading'=>'<h3 class="panel-title text-white"><i class="align-middle" data-feather="filter"></i> Stok</h3>',
            /* 'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah untuk buat Stok</em></div>', */
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
            //'<a class="btn btn-sm btn-success modalButton" value="'.Url::to(['create']).'"><i class="fas fa-plus"></i> Tambah Stok</a>  ' . 
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
            '{toggleData}',
        ]
    ],
    'options'=>['produk'=>'dynagrid-sg'] // a unique identifier is important
]);
?>

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
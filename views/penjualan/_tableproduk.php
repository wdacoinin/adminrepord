<?php

use app\models\DoProdukT;
use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\bootstrap5\Modal;
use yii\helpers\Url;
use app\models\SupplierT;
use app\models\MerekT;
use app\models\WoT;
use yii\helpers\ArrayHelper;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'List Produk';

//restrict action to user
$act = [];
if(Yii::$app->user->identity->divisi <= 2){
    
    if($model->penjualan_status == 'Piutang'){
        $act = 
        [
            'class'=>'kartik\grid\ActionColumn',
            'width'=>'100px',
            'hAlign'=>'center', 
            'contentOptions' => [],
            'header'=>'Actions',
            'template' => '{update}{delete}',
            'buttons'=>[
                'update' => function($url, $model) { 
                    //diffrent controller
                    $modDel = WoT::find()->where(['penjualan' => $model->penjualan])->asArray()->count();
                    if($modDel > 0){

                    }else{
                        if($model->penjualan_produk !== null){

                        $ud = 'index.php?r=penjualan/updateproduk&penjualan_produk=' . $model->penjualan_produk;
                            return '<div class="d-grid gap-0"><a class="btn btn-light modalButton3" value="'. $ud . '"><i class="align-middle" data-feather="edit"></i> Update</a></div>';
                        }else{
                            return null;
                        }
                    }
                },
                'delete' => function($url, $model){
                    //diffrent controller
                    $modDel = WoT::find()->where(['penjualan' => $model->penjualan])->asArray()->count();
                    if($modDel > 0){

                    }else{
                        $controller = Yii::$app->controller;
                        return '<a class="dropdown-item" href="'.Url::to(['penjualan/deleteproduk', 'penjualan_produk' => $model->penjualan_produk]).'" title="Delete" aria-label="Delete" data-pjax="0" data-method="post" data-confirm="Are you sure to delete this item?" tabindex="-1"><i class="align-middle" data-feather="trash-2"></i> Delete</a>';
                    }
                },
            ],
            'dropdown'=>true,
            'order'=>DynaGrid::ORDER_FIX_RIGHT
        ];
    }else{
        $act = [];
    }
}else{
    $act = [];
}
$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'label'=>'Img',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            if($model->doProduk->do_produk_origin > 0){
                $modProdO = DoProdukT::findOne($model->doProduk->do_produk_origin);
                if($modProdO != null){
                    return '<img src="'.$modProdO->url.'" width="100" />';
                }
            }else{
                return '<img src="'.$model->doProduk->url.'" width="100" />';
            }
            
        },
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>'raw'
    ],
    [
        'attribute'=>'produk',
        'value' => 'produk0.nama',
        /* 'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            $controller = Yii::$app->controller;
            $ud = 'index.php?r=do-produk/update&penjualan_produk=' . $model->penjualan_produk;
            return '<a class="btn btn-sm btn-primary modalButton3" value="'. $ud . '">'. $model->produk0->nama. '</a>';
        }, */
        'hAlign'=>'left', 
        'vAlign'=>'middle',
        'width'=>'200px',
        'filter'=>true,
        'format'=>'raw'
    ],
    [
        'attribute'=>'stok_jenis',
        'value' => 'doProduk.stokJenis.stok_jenis_nama',
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'200px',
        'filter'=>true,
        'group'=>false,  // enable grouping
    ],
    [
        'attribute'=>'penjualan_jml', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'attribute'=>'penjualan_harga', 
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
            return $model->penjualan_jml*$model->penjualan_harga;
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
    ],
    $act,
];
if($model->penjualan_status == 'Piutang'){
    $add = '<a class="btn btn-sm btn-secondary mr-2 modalButton3" value="'.Url::to(['penjualan/createprodukwo', 'penjualan' => $penjualan]).'"><i class="fas fa-plus"></i> Tambah Dari WO</a>  ' .
    '<a class="btn btn-sm btn-primary mr-2 modalButton3" value="'.Url::to(['penjualan/createprodukrakitan', 'penjualan' => $penjualan]).'"><i class="fas fa-plus"></i> Tambah Rakitan</a>  ' .
    '<button class="btn btn-sm btn-success mr-2 modalButton3" value="'.Url::to(['penjualan/createproduk', 'penjualan' => $penjualan]).'"><i class="fas fa-plus"></i> Tambah Produk</button>' .
    Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid']);
}else{
    $add = Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid']);
}
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
        'pjax'=>false,
        'responsiveWrap'=>false,
        'panel'=>[
            'heading'=>'<h3 class="panel-title text-white"><i class="align-middle" data-feather="shopping-bag"></i> Penjualan Produk</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah untuk Produk</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=> $add
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
            //'{toggleData}',
        ]
    ],
    'options'=>['id'=>'dynagrid-penjualan_produk'] // a unique identifier is important
]);
?>

<!----MODAL---------------->
<?php
    $js=<<<js
        $('.modalButton3').click( function () {
            $('#modal3').modal('show')
                    .find('#modalContent3')
                    .load($(this).attr('value'));
        });
        $('#modal3').modal({
            backdrop: 'static',
            keyboard: false
         });
    js;
    $this->registerJs($js);
    Modal::begin([
        'title' => '<h2><i class="align-middle" data-feather="alert-circle"></i> </h2>',
        'id' => 'modal3',
        'size' => 'modal-sm',
    ]);
    echo "<div id='modalContent3' class='p-0'></div>";
    Modal::end();
?>
<!----END MODAL-------------->
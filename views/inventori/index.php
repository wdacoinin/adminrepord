<?php

use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\dynagrid\Module;
use kartik\grid\GridView;
use yii\bootstrap5\Modal;
use yii\helpers\Url;
use app\models\LokasiT;
use yii\helpers\ArrayHelper;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'Inventori';

//restrict action to user
$act = [];
if(Yii::$app->user->identity->divisi <= 2){
$act = [
    'class'=>'kartik\grid\ActionColumn',
    'width'=>'50px',
    'contentOptions' => [],
    'header'=>'Actions',
    'template' => '{update}{delete}',
    'buttons'=>[
        'update' => function($url, $model) { 
             if($model->inventori !== null){
             //diffrent controller
             $controller = Yii::$app->controller;
             //$arrayParams = ['pembelian_bahan' => $model->pembelian_bahan];
             //$params = array_merge(["{$controller->id}/update"], $arrayParams);
             $ud = 'index.php?r=' . $controller->id . '/update&inventori=' . $model->inventori;
                 return '<a class="btn btn-light modalButton" value="'. $ud . '"><i class="align-middle" data-feather="edit"></i> Update</a>';
             }else{
                 return null;
             }
         },
         'delete' => function($url, $model) { 
            if($model->inventori !== null){
              //diffrent controller
              $controller = Yii::$app->controller;
              //$arrayParams = ['pembelian_bahan' => $model->pembelian_bahan];
              //$params = array_merge(["{$controller->id}/update"], $arrayParams);
                if($model->inventori == 101){
                    return null;
                }else{
                    $ud = 'index.php?r=' . $controller->id . '/delete&inventori=' . $model->inventori;
                    return '<a class="btn btn-light" href="'. $ud . '" title="Hapus" aria-label="Hapus" data-pjax="0" data-method="post" data-confirm="Hapus Inventori?"><i class="align-middle" data-feather="trash"></i> Hapus</a>';
                }
            }else{
                  return null;
            }
          },

    ],
    'dropdown'=>true,
    'order'=>DynaGrid::ORDER_FIX_RIGHT
];
$act2 = [
    'class'=>'kartik\grid\ActionColumn',
    'width'=>'200px',
    'contentOptions' => [],
    'header'=>'Actions',
    'template' => '{update}',
    'buttons'=>[
        'update' => function($url, $model) { 
             if($model->lokasi !== null){
             //diffrent controller
             //$controller = Yii::$app->controller;
             //$arrayParams = ['pembelian_bahan' => $model->pembelian_bahan];
             //$params = array_merge(["{$controller->id}/update"], $arrayParams);
             $ud = 'index.php?r=lokasi/update&lokasi=' . $model->lokasi;
                 return '<a class="btn btn-light modalButton" value="'. $ud . '"><i class="align-middle" data-feather="edit"></i> Update</a>';
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
    $act2 = [];
}

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'attribute'=>'kode',
        'value'=>'kode',
        'hAlign'=>'left', 
        'vAlign'=>'top',
        'width'=>'50px',
        'filter' => true,
    ],
    [
        'attribute'=>'lokasi',
        'value'=>'lokasi0.nama',
        'hAlign'=>'center', 
        'vAlign'=>'top',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(LokasiT::find()->orderBy('nama')->asArray()->all(), 'lokasi', 'nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Pilih'],
        'format'=>'raw',
        'group'=>true,  // enable grouping
        'format'=>'raw'
    ],
    $act
];

$columns2 = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    'nama',
    'detail',
    $act2
];
?>
<div class="row">
<div class="col-md-6">
<?php
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
            'heading'=>'<h3 class="panel-title text-white"><i class="align-middle" data-feather="layers"></i>  Inventori</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah Inventori</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
            '<a class="btn btn-sm btn-success modalButton" value="'.Url::to(['create']).'"><i class="fas fa-plus"></i> Tambah Inventori</a>  ' .  
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
            '{toggleData}',
        ]
    ],
    'options'=>['inventori'=>'dynagrid-inventori'] // a unique identifier is important
]);
?>
</div>
<div class="col-md-6">
<?php
echo DynaGrid::widget([
    'columns' => $columns2,
    'theme'=> 'panel-dark',
    'showPersonalize'=>true,
    'storage' => 'session',
    'gridOptions'=>[
        'dataProvider'=>$dataProvider2,
        'filterModel'=>$searchModel2,
        'showPageSummary'=>true,
        'pageSummaryRowOptions'=>['class' => 'kv-page-summary table-light'],
        'floatHeader'=>true,
        'pjax'=>false,
        'responsiveWrap'=>false,
        'panel'=>[
            'heading'=>'<h3 class="panel-title text-white"><i class="align-middle" data-feather="folder"></i>  Lokasi</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah Lokasi</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
            '<a class="btn btn-sm btn-success modalButton" value="'.Url::to(['lokasi/create']).'"><i class="fas fa-plus"></i> Tambah Lokasi</a>  ' .  
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
        ]
    ],
    'options'=>['lokasi'=>'dynagrid-lokasi'] // a unique identifier is important
]);
?>
</div>
</div>
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
        'size' => 'modal-sm',
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
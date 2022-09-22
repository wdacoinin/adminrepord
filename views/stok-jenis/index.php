<?php

use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\bootstrap5\Modal;
use yii\helpers\Url;
// on your view layout file
use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this);
$this->title = 'Jenis Stok';

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'attribute'=>'stok_jenis_nama',
        'value'=>'stok_jenis_nama',
        'hAlign'=>'left', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filter'=>true,
        'format'=>'raw'
    ],
    [
        'class'=>'kartik\grid\ActionColumn',
        'width'=>'100px',
        'hAlign'=>'center', 
        'contentOptions' => [],
        'header'=>'Actions',
        'template' => '{update}',
        'buttons'=>[
            'update' => function($url, $model) { 
                 if($model->stok_jenis !== null){
 
                     
                 //diffrent controller
                 $controller = Yii::$app->controller;
                 //$arrayParams = ['pembelian_bahan' => $model->pembelian_bahan];
                 //$params = array_merge(["{$controller->id}/update"], $arrayParams);
                 $ud = 'index.php?r=' . $controller->id . '/update&stok_jenis=' . $model->stok_jenis;
                     return '<a class="btn btn-light modalButton" value="'. $ud . '"><i class="align-middle" data-feather="edit"></i> Update</a>';
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
    'showPersonalize'=>true,
    'storage' => 'session',
    'gridOptions'=>[
        'dataProvider'=>$dataProvider,
        //'filterModel'=>$searchModel,
        'showPageSummary'=>true,
        'responsiveWrap'=>true,
        'pageSummaryRowOptions'=>['class' => 'kv-page-summary table-light'],
        'floatHeader'=>true,
        'pjax'=>false,
        'responsiveWrap'=>false,
        'panel'=>[
            'heading'=>'<h3 class="panel-title text-white"><i class="align-middle" data-feather="credit-card"></i>  Jenis Stok</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah untuk buat Jenis Stok</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
            '<a class="btn btn-sm btn-success modalButton" value="'.Url::to(['create']).'"><i class="fas fa-plus"></i> Tambah Jenis Stok</a>  ' . 
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
            '{toggleData}',
        ]
    ],
    'options'=>['stok_jenis'=>'dynagrid-1'] // a unique identifier is important
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

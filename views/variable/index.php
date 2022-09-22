<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Divisi;
use yii\helpers\ArrayHelper;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\bootstrap5\Modal;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'MJ Teknologi Semarang Setting';

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'attribute'=>'nama',
        'filter'=>false
    ],
    [
        'attribute'=>'divisi',
        'filter'=>false
    ],
    [
        'attribute'=>'val', 
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>['decimal', 0],
        'pageSummary'=>false,
        'filter'=>false
    ],
    [
        'attribute'=>'detail',
        'filter'=>false
    ],
    [
        'attribute'=>'status',
        'filter'=>false
    ],
    [
        'class'=>'kartik\grid\ActionColumn',
        'width'=>'200px',
        'contentOptions' => [],
        'header'=>'Actions',
        'template' => '{update}',
        'buttons'=>[
            'update' => function($url, $model) { 
                 if($model->variable !== null){
 
                     
                 //diffrent controller
                 $controller = Yii::$app->controller;
                 //$arrayParams = ['pembelian_bahan' => $model->pembelian_bahan];
                 //$params = array_merge(["{$controller->id}/update"], $arrayParams);
                 $ud = 'index.php?r=' . $controller->id . '/update&variable=' . $model->variable;
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
        'pageSummaryRowOptions'=>['class' => 'kv-page-summary table-light'],
        'floatHeader'=>true,
        'pjax'=>false,
        'responsiveWrap'=>false,
        'panel'=>[
            'heading'=>'<h3 class="panel-title text-white"><i class="align-middle" data-feather="settings"></i>  Setting</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>*Setting</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
               /*  Html::a('<i class="fas fa-plus"></i>', ['create'], ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>'Tambah Setting']) . ' ' . */
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
        ]
    ],
    'options'=>['variable'=>'dynagrid-1'] // a unique identifier is important
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
</style>
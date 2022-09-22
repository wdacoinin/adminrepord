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
$this->title = 'DO Pembelian';

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'attribute'=>'do',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            $controller = Yii::$app->controller;
            $ud = 'index.php?r=' . $controller->id . '/update&do=' . $model->do;
            return '<a class="btn btn-sm btn-primary modalButton" value="'. $ud . '"> <i class="align-middle" data-feather="edit"></i> '. $model->faktur. '</a>';
        },
        'hAlign'=>'left', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filter'=>true,
        'format'=>'raw'
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
    /* [
        'attribute'=>'supplier',
        'value'=>'supplier0.supplier_nama',
        'hAlign'=>'left', 
        'vAlign'=>'middle',
        'width'=>'150px',
        'filter'=>true,
        'group'=>true,  // enable grouping
    ], */
    [
        'attribute'=>'supplier',
        'value'=>'supplier0.supplier_nama',
        'hAlign'=>'left', 
        'vAlign'=>'top',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(SupplierT::find()->orderBy('supplier_nama')->asArray()->all(), 'supplier', 'supplier_nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Pilih'],
        'format'=>'raw',
        'group'=>true,  // enable grouping
        'format'=>'raw'
    ],
    [
        'class'=>'kartik\grid\ActionColumn',
        'width'=>'200px',
        'hAlign'=>'center', 
        'contentOptions' => [],
        'header'=>'Actions',
        'template' => '{update}{delete}',
        'buttons'=>[
            'update' => function($url, $model) { 
                 if($model->do !== null){
 
                     
                 //diffrent controller
                 $controller = Yii::$app->controller;
                 //$arrayParams = ['pembelian_bahan' => $model->pembelian_bahan];
                 //$params = array_merge(["{$controller->id}/update"], $arrayParams);
                 $ud = 'index.php?r=' . $controller->id . '/update&do=' . $model->do;
                     return '<div class="d-grid gap-0"><a class="btn btn-light modalButton" value="'. $ud . '"><i class="align-middle" data-feather="edit"></i> Update</a></div>';
                 }else{
                     return null;
                 }
             },
        ],
        'dropdown'=>true,
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
        'toolbar' =>  [
            ['content'=>
            '<a class="btn btn-sm btn-success modalButton" value="'.Url::to(['create']).'"><i class="fas fa-plus"></i> Tambah DO</a>  ' . 
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
            '{toggleData}',
        ]
    ],
    'options'=>['do'=>'dynagrid-do'] // a unique identifier is important
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

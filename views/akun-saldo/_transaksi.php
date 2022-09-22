<?php

use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\bootstrap5\Modal;
use yii\helpers\Url;
use app\models\AktivaT;
use app\models\AkunT;
use app\models\BackendUser;
use app\models\BebanT;
use yii\helpers\ArrayHelper;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$controller = Yii::$app->controller;
$create = Url::to(['akun-saldo/createtransaksi']);

$this->title = 'Transaksi';

//restrict action to user
$act = [];
if(Yii::$app->user->identity->divisi <= 2){
$act = [
    'class'=>'kartik\grid\ActionColumn',
    'width'=>'80px',
    'hAlign'=>'center', 
    'contentOptions' => [],
    'header'=>'Actions',
    'template' => '{update}{delete}',
    'buttons'=>[
        'update' => function($url, $model) { 
            if($model->aktiva == 12 || $model->aktiva == 10){
                return null;
            }else{
                //diffrent controller
                $controller = Yii::$app->controller;
                $ud = 'index.php?r=' . $controller->id . '/update&akun_saldo=' . $model->akun_saldo;
                if($model->akun_saldo !== null){
                //$arrayParams = ['pembelian_bahan' => $model->pembelian_bahan];
                //$params = array_merge(["{$controller->id}/update"], $arrayParams);
                return '<div class="d-grid gap-0"><a class="btn btn-light modalButton" value="'. $ud . '"><i class="align-middle" data-feather="edit"></i> Update</a></div>';
                }
            }
         },
         'delete' => function($url, $model){
            if($model->aktiva == 12 || $model->aktiva == 10){
                return null;
            }else{
                //diffrent controller
                $controller = Yii::$app->controller;
                return '<a class="dropdown-item" href="/regene/web/index.php?r=' . $controller->id . '/delete&akun_saldo='.$model->akun_saldo.'" title="Delete" aria-label="Delete" data-pjax="0" data-method="post" data-confirm="Are you sure to delete this item?" tabindex="-1"><i class="align-middle" data-feather="trash-2"></i> Delete</a>';
                
            }
        },
    ],
    'dropdown'=>true,
    'order'=>DynaGrid::ORDER_FIX_RIGHT
];
}else{
    $act = [];
}

$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'attribute'=>'notrans',
        'hAlign'=>'left', 
        'vAlign'=>'top',
        'width'=>'100px',
        'filter'=>true,
        'group'=>true,  // enable grouping
        'format'=>'raw'
    ],
    [
        'attribute'=>'akun',
        'value'=>'akun0.akun_ref',
        'hAlign'=>'left', 
        'vAlign'=>'top',
        'width'=>'100px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> ArrayHelper::map(AkunT::find()->select(["akun, CONCAT(akun_nama, '-', akun_ref, ' An.', an) AS akun_ref"])->orderBy('akun_ref ASC')->asArray()->all(), 'akun', 'akun_ref'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Pilih'],
        'format'=>'raw',
        'group'=>true,  // enable grouping
        'format'=>'raw'
    ],
    [
        'attribute'=>'aktiva',
        'value'=>'aktiva0.aktiva_nama',
        'hAlign'=>'left', 
        'vAlign'=>'top',
        'width'=>'80px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(AktivaT::find()->orderBy('aktiva_nama')->asArray()->all(), 'aktiva', 'aktiva_nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Pilih'],
        'format'=>'raw',
        'group'=>true,  // enable grouping
        'format'=>'raw'
    ],
    [
        'attribute'=>'beban',
        'value'=>'beban0.nama',
        'hAlign'=>'center', 
        'vAlign'=>'top',
        'width'=>'120px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(BebanT::find()->orderBy('nama')->asArray()->all(), 'beban', 'nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Pilih'],
        'group'=>true,  // enable grouping
    ],
    [
        'attribute'=>'ket',
        'hAlign'=>'left', 
        'vAlign'=>'top',
        'width'=>'150px',
        'filter'=>false,
        'format'=>'raw'
    ],
    [
        'attribute'=>'datetime',
        'width'=>'150px',
        'options' => [
            'format' => 'YYYY-MM-DD',
            ],        
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => ([       
          'attribute' => 'datetime',
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
            "apply.daterangepicker" => "function() { apply_filter('datetime') }",
          ],
        ])
    ],
    [
        'attribute'=>'user',
        'value'=>'user0.nama',
        'hAlign'=>'left', 
        'vAlign'=>'top',
        'width'=>'150px',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(BackendUser::find()->where('divisi > 1')->orderBy('nama')->asArray()->all(), 'id', 'nama'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Pilih'],
        'format'=>'raw',
        'group'=>true,  // enable grouping
        'format'=>'raw'
    ],
    [
        'label' => 'IN',
        'attribute'=>'jml', 
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            if($model->aktiva0->d_k == 'Debit'){
                return $model->jml;
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
    [
        'label' => 'OUT',
        'attribute'=>'jml', 
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            if($model->aktiva0->d_k == 'Kredit'){
                return $model->jml;
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
    [
        'label' => 'Laba/Rugi',
        'attribute'=>'jml', 
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            if($model->aktiva0->d_k == 'Kredit'){
                $debit = 0;
                $kredit = (int) $model->jml;
                $rl = - $kredit;
            }elseif($model->aktiva0->d_k == 'Debit'){
                $debit = (int) $model->jml;
                $kredit = 0;
                $rl = $debit;
            }
            return $rl;
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
            'heading'=>'<h3 class="panel-title text-white"><i class="align-middle" data-feather="filter"></i> Transaksi</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>* Klik Tambah untuk buat Transaksi</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
            '<a class="btn btn-sm btn-success modalButton" value="'.$create.'"><i class="fas fa-plus"></i> Tambah Transaksi</a>  ' . 
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
            '{toggleData}',
        ]
    ],
    'options'=>['id'=>'dynagrid-akun_saldo'] // a unique identifier is important
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
        'size' => 'modal-lg modal-dialog-centered modal-dialog-scrollable',
    ]);
    echo "<div id='modalContent' class='p-0'></div>";
    Modal::end();
?>
<!----END MODAL-------------->


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

<style>	
    .form-group {
        margin-bottom: 4px !important;
    }

    .control-label {
        margin-bottom: 2px !important;
    }

    .hide {
        display: none;
    }

    .modal {
        overflow-y: auto;
    }
    .modal-body{
        padding: 0px !important;
    }
    .dropdown-menu.show{
        text-align: center !important;
    }
</style>

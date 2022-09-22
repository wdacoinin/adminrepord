<?php

use app\models\BackendUser;
use app\models\DoProdukT;
use app\models\PenjualanT;
use app\models\Penjualanv;
use app\models\RakitanT;
use app\models\VariableT;
use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use kartik\widgets\DatePicker;
use yii\bootstrap5\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
// on your view layout file
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */
$this->title = 'Salary';

$thismonth = date('Y-m') . '-25';
$monthbefore =  date('Y-m', strtotime('-1 month')) . '-26';
?>
<div class="row p-2 bg-light">
<div class="col-md-6">
    <?php
    echo DatePicker::widget([
        //'options' => ['id' => 'datestart'],
        'name' => 'start',
        'value' => $monthbefore,
        'type' => DatePicker::TYPE_RANGE,
        //'options2' => ['id' => 'dateend'],
        'name2' => 'end',
        'value2' => $thismonth,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>
</div>
<div class="col-md-6">
    <button id="startend" class="btn btn-sm btn-success"> Cari</button>
</div>
</div>

<?php
if(isset($_GET['start']) && isset($_GET['end'])){
$columns = [
    ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    /* [
        'label'=>'Gambar',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            return '<img src="'.$model->url.'" width="100" />';
        },
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'50px',
        'filter'=>false,
        'format'=>'raw'
    ], */
    [
        'attribute'=>'nama',
        'hAlign'=>'left', 
        'vAlign'=>'middle',
        'width'=>'50px',
        'filter'=>false,
    ],
    [
        'label'=>'Divisi',
        'attribute'=>'divisi0.nama',
        'hAlign'=>'center', 
        'vAlign'=>'middle',
        'width'=>'50px',
        'filter'=>false,
        'group' =>true
    ],
    [
        'label' => 'Upah Pokok',
        'attribute'=>'gaji',
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'label'=>'Jml Rakitan',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            $date = date('Y-m');
            $rakitan = RakitanT::find()->where(['id_user' => $model->id])
            ->andWhere("rakitan_date BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")
            ->count();
            return $rakitan;
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'40px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'label'=>'Bonus Rakitan',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            $date = date('Y-m');
            $rakitan = RakitanT::find()->where(['id_user' => $model->id])
            ->andWhere("rakitan_date BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")
            ->count();
            $var_rakitan = VariableT::findOne(6);
            $valrakitan = $var_rakitan->val;
            $tot = $rakitan * $valrakitan;
            return $tot;
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'label'=>'Jml Penjualan',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            $penjualan = PenjualanT::find()->where(['user' => $model->id])
            ->andWhere("penjualan_tgl BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")->count();
            return $penjualan;
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'40px',
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'filter'=>false
    ],
    [
        'label'=>'Penjualan',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            /* $penjualan = PenjualanT::find()
            ->select('penjualan.penjualan_tgl, penjualan.user, SUM(penjualan_produk.total) AS total')
            ->where(['penjualan.user' => $model->id])
            ->andWhere("penjualan.penjualan_tgl BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")
            ->join("LEFT JOIN", "(SELECT penjualan_produk.penjualan, SUM(penjualan_produk.penjualan_jml*penjualan_produk.penjualan_harga) AS total FROM penjualan_produk AS penjualan_produk GROUP BY penjualan_produk.penjualan) AS penjualan_produk", "penjualan_produk.penjualan=penjualan.penjualan")
            ->groupBy('penjualan.user')
            ->asArray()->one(); */
            //var_dump($penjualan);
                if($model->divisi == 3){
            
                    $penjualan = Penjualanv::find()->select('sales, SUM(total) AS total')->where(['sales' => $model->nama])
                    ->andWhere("penjualan_tgl BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")
                    ->groupBy('sales')
                    ->asArray()->one();
            
                    if($penjualan != null){
                        $tot = (int) $penjualan['total'];
                        return $tot;
                    }else{
                        return 0;
                    }
                    
                }elseif($model->divisi == 2){
                    
                    $penjualang = Penjualanv::find()->select('SUM(total) AS total')
                    ->where("penjualan_tgl BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")
                    ->asArray()->one();
                    $tot = (int) $penjualang['total'];

                    return $tot;
                }else{
                    return 0;
                }
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 2],
        'pageSummary'=>false,
        'filter'=>false
    ],
    [
        'label'=>'Fee Penjualan',
        'value'=>function ($model, $key, $index, $widget) { //diffrent controller
            $date = date('Y-m');
            /* $penjualan = PenjualanT::find()
            ->select('penjualan.penjualan_tgl, penjualan.user, penjualan_produk.total')
            ->where(['penjualan.user' => $model->id])
            ->andWhere("penjualan.penjualan_tgl BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")
            ->join("LEFT JOIN", "(SELECT penjualan_produk.penjualan, SUM(penjualan_produk.penjualan_jml*penjualan_produk.penjualan_harga) AS total FROM penjualan_produk AS penjualan_produk GROUP BY penjualan_produk.penjualan) AS penjualan_produk", "penjualan_produk.penjualan=penjualan.penjualan")
            ->groupBy('penjualan.user')
            ->asArray()->one();
            var_dump($penjualan); */
                if($model->divisi == 3){
            
                    $penjualan = Penjualanv::find()->select('sales, SUM(total) AS total')->where(['sales' => $model->nama])
                    ->andWhere("penjualan_tgl BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")
                    ->groupBy('sales')
                    ->asArray()->one();
                    if($penjualan != null){
                        $bonus = VariableT::findOne(5);
                        $var_bonus = VariableT::findOne(8);
                        $valbonus = (int) $var_bonus->val;

                        $penjbagis = (int) $penjualan['total'] / $valbonus;
                        $penjbagi = round($penjbagis, 0);
                        $tot = $bonus->val * $penjbagi;
                    }else{
                        return 0;
                    }
                }elseif($model->divisi == 2){
                    $penjualang = Penjualanv::find()->select('SUM(total) AS total')
                    ->where("penjualan_tgl BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")
                    ->asArray()->one();
                    
                    $bonus = VariableT::findOne(5);
                    $var_bonus = VariableT::findOne(9);
                    $valbonus = (int) $var_bonus->val;

                    $penjbagis = (int) $penjualang['total'] / $valbonus;
                    $penjbagi = round($penjbagis, 0);
                    $tot = $bonus->val * $penjbagi;
                }else{
                    $tot = 0;
                }
                
                return $tot;
        },
        'hAlign'=>'right', 
        'vAlign'=>'middle',
        'width'=>'80px',
        'format'=>['decimal', 2],
        'pageSummary'=>true,
        'filter'=>false
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
            'heading'=>'<h3 class="panel-title text-white"><i class="align-middle" data-feather="folder"></i>  Salary</h3>',
            'before' =>  '<div style="padding-top: 7px;"><em>*Salary</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
            /* '<a class="btn btn-sm btn-success modalButton" value="'.Url::to(['create']).'"><i class="fas fa-plus"></i> Tambah Salary</a>  ' . */  
                Html::a('<i class="fas fa-redo-alt"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
            '{toggleData}',
        ]
    ],
    'options'=>['id'=>'dynagrid-salary'] // a unique identifier is important
]);
}
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
        'size' => 'modal-md',
    ]);
    echo "<div id='modalContent' class='p-0'></div>";
    Modal::end();
?>
<!----END MODAL-------------->
<script>
    
    $(document).ready(function(){
        $('#startend').on('click', function(){
            var start = $("[name=start]").val();
            var end = $("[name=end]").val();

            location.replace('index.php?r=salary&start=' + start + '&end=' + end + '');
        });
    });
</script>

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
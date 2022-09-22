<?php

use app\models\DoProdukT;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\InventoriT;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\KategoriT;
use app\models\MyFormatter;
use app\models\PenjualanProdukT;
use app\models\StokJenisT;
use app\models\WoProdukT;
use kartik\widgets\FileInput;
use kartik\depdrop\DepDrop;
use kartik\number\NumberControl;
use yii\bootstrap5\Modal;
use yii\helpers\Url;

$controller = Yii::$app->controller;
$ud = 'index.php?r=' . $controller->id . '/inputproduk&wo=' . $model->wo;
$ud2 = 'index.php?r=' . $controller->id . '/bataljual&wo=' . $model->wo;
$actionpasang = 'index.php?r=' . $controller->id . '/pasang';
$actionhapus = 'index.php?r=' . $controller->id . '/out';
?>

<div class="col-md-12">
    <div class="row bg-light mb-4">
        <?php if($model->penjualan > 0){ 
            if(Yii::$app->user->identity->divisi < 2){
        ?>
        <div class="col-md-2 m-3"><a class="btn btn-warning" href="<?php echo $ud2; ?>"><i class="align-middle" data-feather="edit"></i> Batalkan Penjualan WO</a></div>
        <?php }
        }else{ ?>
        <div class="col-md-2 m-3"><a class="btn btn-primary modalButton" value="<?php echo $ud; ?>"><i class="align-middle" data-feather="edit"></i> Input Produk</a></div>
        <?php } ?>

        <div class="col-md-3 m-3">
            <?php
            $modWodone = WoProdukT::find()->where(['wo' => $model->wo])->andWhere("wo_produk_status IN ('Terpasang')")->asArray()->count();
            $countwodone = WoProdukT::find()->where(['wo' => $model->wo])->asArray()->count();

            if($modWodone == $countwodone){
                $datastatuswo = ['Start' => 'Start', 'Install' => 'Install', 'Soldout' => 'Soldout'];
            }else{
                $datastatuswo = ['Start' => 'Start'];
            }

            echo '<div class="form-group">';
            echo '<label class="control-label">Status Working Order</label>';
            echo Select2::widget([
                'name' => 'status',
                'data' => $datastatuswo,
                'value' => $model->status,
                'options' => [
                    'id' => 'status',
                    'placeholder' => 'Pilih Kategori ...',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    //'dropdownParent' => '#modal'
                ],
            ]);
            echo '</div>';
            ?>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="row">

        <?php
            //START LIST
            $modList = WoProdukT::find()->select(["
            CONCAT(produk.nama, ' - ', merek.nama, ', QTY:', wo_produk.wo_jml, ', Harga:', wo_produk.wo_harga) AS nama,
            wo_produk.wo_produk,  
            wo_produk.wo_produk_status, 
            do_produk.do_produk, 
            do_produk.do_produk_origin, 
            do_produk.url
            "])
            ->join("LEFT JOIN", "produk", "wo_produk.produk=produk.produk")
            ->join("LEFT JOIN", "merek", "produk.merek=merek.merek")
            ->join("LEFT JOIN", "do_produk", "wo_produk.do_produk=do_produk.do_produk")
            ->join("LEFT JOIN", "inventori", "do_produk.inventori=inventori.inventori")
            ->where(['wo_produk.wo' => $model->wo])->asArray()->all();

            echo '<div class="card" style="width: 18rem;">';
            echo '<div class="card-header bg-secondary text-white">List Produk Order</div>';
                echo '<div class="row g-0">';
                    echo '<div class="col-md-12">';
                        echo '<div class="card-body">';
                        echo '<ul class="list-group list-group-flush">';
                        foreach($modList as $rowList){
                            $controller = Yii::$app->controller;
                            $ud = 'index.php?r=' . $controller->id . '/out&wo_produk=' . $rowList['wo_produk'];
                            $checkpenj = PenjualanProdukT::find()
                            ->join("LEFT JOIN", "wo_produk", "penjualan_produk.do_produk=wo_produk.do_produk")
                            ->where(['penjualan_produk.do_produk' => $rowList['do_produk'], 'wo_produk.wo' => $model->wo])
                            ->count();
                            $modProd = DoProdukT::findOne($rowList['do_produk_origin']);
                            if($modProd != null){
                                $img = '<img src="'.$modProd['url'].'" width="100" /></br>';
                            }else{
                                $img = '<img src="'.$rowList['url'].'" width="100" /></br>';
                            }
                            if($model->penjualan > 0 && Yii::$app->user->identity->id > 1){
                                echo '<li class="list-group-item">'.$img.$rowList['nama'].'</li>';
                            }else{
                                if((int) $checkpenj > 0){
                                    echo '<li class="list-group-item">'.$img.$rowList['nama'].'</li>';
                                }else{
                                    if($rowList['wo_produk_status'] == 'Ok'){
                                        echo '<li class="list-group-item">'.$img.$rowList['nama'].'<br> 
                                        <a class="btn btn-sm btn-danger modalButton" value="'. $ud . '"> <i class="align-middle" data-feather="trash"></i> Hapus</a> 
                                        <button id="pasang" data-wo_produk="'.$rowList['wo_produk'].'" class="btn btn-sm btn-success"> <i class="align-middle" data-feather="check-circle"></i> Stok Ready</button>
                                        </li>';
                                    }else{
                                        echo '<li class="list-group-item">'.$img.$rowList['nama'].'<br> <button id="out" data-wo_produk="'.$rowList['wo_produk'].'"  class="btn btn-sm btn-danger"> <i class="align-middle" data-feather="trash"></i> Hapus</button></li>';
                                    }
                                }
                            }
                        }
                        echo '</ul>'; 

                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        ?>

        <?php
            //Terpasang LIST
            $modList = WoProdukT::find()->select(["
            CONCAT(produk.nama, ' - ', merek.nama, ', QTY:', wo_produk.wo_jml, ', Harga:', wo_produk.wo_harga) AS nama,
            wo_produk.wo_produk,  
            wo_produk.wo_produk_status, 
            do_produk.do_produk, 
            do_produk.do_produk_origin, 
            do_produk.url
            "])
            ->join("LEFT JOIN", "produk", "wo_produk.produk=produk.produk")
            ->join("LEFT JOIN", "merek", "produk.merek=merek.merek")
            ->join("LEFT JOIN", "do_produk", "wo_produk.do_produk=do_produk.do_produk")
            ->join("LEFT JOIN", "inventori", "do_produk.inventori=inventori.inventori")
            ->where(['wo_produk.wo' => $model->wo, 'wo_produk.wo_produk_status' => 'Terpasang'])->asArray()->all();

            echo '<div class="card" style="width: 18rem;">';
            echo '<div class="card-header bg-primary text-white">List Produk Terpasang</div>';
                echo '<div class="row g-0">';
                    echo '<div class="col-md-12">';
                        echo '<div class="card-body">';
                        echo '<ul class="list-group list-group-flush">';
                        foreach($modList as $rowList){
                            $controller = Yii::$app->controller;
                            $ud = 'index.php?r=' . $controller->id . '/out&wo_produk=' . $rowList['wo_produk'];
                            $checkpenj = PenjualanProdukT::find()
                            ->join("LEFT JOIN", "wo_produk", "penjualan_produk.do_produk=wo_produk.do_produk")
                            ->where(['penjualan_produk.do_produk' => $rowList['do_produk'], 'wo_produk.wo' => $model->wo])
                            ->count();
                            $modProd = DoProdukT::findOne($rowList['do_produk_origin']);
                            if($modProd != null){
                                $img = '<img src="'.$modProd['url'].'" width="100" /></br>';
                            }else{
                                $img = '<img src="'.$rowList['url'].'" width="100" /></br>';
                            }
                            if($model->penjualan > 0 && Yii::$app->user->identity->id > 1){
                                echo '<li class="list-group-item">'.$img.$rowList['nama'].'</li>';
                            }else{
                                echo '<li class="list-group-item">'.$img.$rowList['nama'].'<br> 
                                <button class="btn btn-sm btn-success"> <i class="align-middle" data-feather="check-circle"></i> Terpasang</button>
                                </li>';
                            }
                        }
                        echo '</ul>'; 

                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
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
<style>
    .list-group-item {
        font-size: 10px !important;
        padding: 3px !important;
    }
    .card-body {
        padding: 3px !important;
    }
</style>
<!----END MODAL-------------->


<script>
    $(document).ready(function(){
        $('#pasang').on('click', function(){
            var wo_produk = $(this).data('wo_produk');
            console.log(wo_produk);

            $.ajax({
                type: "POST",
                url: '<?php echo $actionpasang; ?>',
                data: {
                    wo_produk: wo_produk
                },
                dataType: "json",
                success: function(data) {
                    if(data.hasil == 'success'){
                        location.reload();
                    }
                },
                error: function(er) {
                    params.error(er);
                }
            });
        });
        
        $('#out').on('click', function(){
            var wo_produk = $(this).data('wo_produk');
            console.log(wo_produk);

            $.ajax({
                type: "POST",
                url: '<?php echo $actionhapus; ?>',
                data: {
                    wo_produk: wo_produk
                },
                dataType: "json",
                success: function(data) {
                    if(data.hasil == 'success'){
                        location.reload();
                    }
                },
                error: function(er) {
                    params.error(er);
                }
            });
        });
    });
</script>
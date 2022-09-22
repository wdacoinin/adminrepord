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
use kartik\widgets\FileInput;
use kartik\depdrop\DepDrop;
use kartik\number\NumberControl;
use yii\bootstrap5\Modal;
use yii\helpers\Url;

$controller = Yii::$app->controller;
$ud = 'index.php?r=' . $controller->id . '/inputproduk&rakitan=' . $model->rakitan;
$ud2 = 'index.php?r=' . $controller->id . '/bataljual&rakitan=' . $model->rakitan;
?>
<?php if($model->penjualan > 0){ 
    if(Yii::$app->user->identity->divisi < 2){
?>
<div class="col-md-3 m-3"><a class="btn btn-warning" href="<?php echo $ud2; ?>"><i class="align-middle" data-feather="edit"></i> Batalkan Penjualan Rakitan</a></div>
<?php }
}else{ ?>
<div class="col-md-3 m-3"><a class="btn btn-primary modalButton" value="<?php echo $ud; ?>"><i class="align-middle" data-feather="edit"></i> Input Produk</a></div>
<?php } ?>

<div class="row">

<?php
    //MONITOR LIST
    $modMon = DoProdukT::find()->select(["
    do_produk.do_produk, 
    do_produk.do_produk_origin, 
    do_produk.url, 
    CASE WHEN do_produk.do_produk_origin > 0 THEN
    CONCAT(produk.nama, '<br> Label : ', produk.produk, '-', do_produk.do_produk_origin, '<br> Qty: ', do_produk.do_jml, '<br> Rp. ', FORMAT(do_produk.harga_jual, 0, 'id_ID'))
    ELSE
    CONCAT(produk.nama, '<br> Label : ', produk.produk, '-', do_produk.do_produk, '<br> Qty: ', do_produk.do_jml, '<br> Rp. ', FORMAT(do_produk.harga_jual, 0, 'id_ID'))
    END AS nama
    "])
    ->join("LEFT JOIN", "produk", "do_produk.produk=produk.produk")
    ->join("LEFT JOIN", "do", "do_produk.do=do.do")
    ->join("LEFT JOIN", "inventori", "do_produk.inventori=inventori.inventori")
    ->where(['do_produk.rakitan' => $model->rakitan, 'produk.kategori' => 23])->asArray()->all();

    echo '<div class="card m-2" style="width: 18rem;">';
        echo '<div class="row g-0">';
            echo '<div class="col-md-4">';
                echo '<img src="../assets/images/monitor.png" class="img-fluid rounded-start" alt="...">';
            echo '</div>';
            echo '<div class="col-md-8">';
                echo '<div class="card-body">';

                echo '<ul class="list-group list-group-flush">';
                foreach($modMon as $rowMon){
                    $controller = Yii::$app->controller;
                    $ud = 'index.php?r=' . $controller->id . '/out&do_produk=' . $rowMon['do_produk'];
                    $checkpenj = PenjualanProdukT::find()
                    ->join("LEFT JOIN", "do_produk", "penjualan_produk.do_produk=do_produk.do_produk")
                    ->where(['penjualan_produk.do_produk' => $rowMon['do_produk'], 'do_produk.rakitan' => $model->rakitan])
                    ->count();
                    $modProd = DoProdukT::findOne($rowMon['do_produk_origin']);
                    if($modProd != null){
                        $img = '<img src="'.$modProd['url'].'" width="100" /></br>';
                    }else{
                        $img = '<img src="'.$rowMon['url'].'" width="100" /></br>';
                    }
                    if($model->penjualan > 0 && Yii::$app->user->identity->id > 1){
                        echo '<li class="list-group-item">'.$img.$rowMon['nama'].'</li>';
                    }else{
                        if((int) $checkpenj > 0){
                            echo '<li class="list-group-item">'.$img.$rowMon['nama'].'</li>';
                        }else{
                            echo '<li class="list-group-item">'.$img.$rowMon['nama'].'<br> <a class="btn btn-sm btn-warning modalButton" value="'. $ud . '"> <i class="align-middle" data-feather="repeat"></i> Update</a></li>';
                        }
                    }
                }
                echo '</ul>'; 

                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';

    //Procie LIST
    $modProc = DoProdukT::find()->select(["
    do_produk.do_produk, 
    do_produk.do_produk_origin, 
    do_produk.url, 
    CASE WHEN do_produk.do_produk_origin > 0 THEN
    CONCAT(produk.nama, '<br> Label : ', produk.produk, '-', do_produk.do_produk_origin, '<br> Qty: ', do_produk.do_jml, '<br> Rp. ', FORMAT(do_produk.harga_jual, 0, 'id_ID'))
    ELSE
    CONCAT(produk.nama, '<br> Label : ', produk.produk, '-', do_produk.do_produk, '<br> Qty: ', do_produk.do_jml, '<br> Rp. ', FORMAT(do_produk.harga_jual, 0, 'id_ID'))
    END AS nama
    "])
    ->join("LEFT JOIN", "produk", "do_produk.produk=produk.produk")
    ->join("LEFT JOIN", "do", "do_produk.do=do.do")
    ->join("LEFT JOIN", "inventori", "do_produk.inventori=inventori.inventori")
    ->where(['do_produk.rakitan' => $model->rakitan])
    ->andWhere("produk.kategori IN ('29', '10', '32')")->asArray()->all();

    echo '<div class="card m-2" style="width: 18rem;">';
        echo '<div class="row g-0">';
            echo '<div class="col-md-4">';
                echo '<img src="../assets/images/processor.png" class="img-fluid rounded-start" alt="...">';
            echo '</div>';
            echo '<div class="col-md-8">';
                echo '<div class="card-body">';

                echo '<ul class="list-group list-group-flush">';
                foreach($modProc as $rowProc){
                    $controller = Yii::$app->controller;
                    $ud = 'index.php?r=' . $controller->id . '/out&do_produk=' . $rowProc['do_produk'];
                    $checkpenj = PenjualanProdukT::find()
                    ->join("LEFT JOIN", "do_produk", "penjualan_produk.do_produk=do_produk.do_produk")
                    ->where(['penjualan_produk.do_produk' => $rowProc['do_produk'], 'do_produk.rakitan' => $model->rakitan])
                    ->count();
                    $modProd = DoProdukT::findOne($rowProc['do_produk_origin']);
                    if($modProd != null){
                        $img = '<img src="'.$modProd['url'].'" width="100" /></br>';
                    }else{
                        $img = '<img src="'.$rowProc['url'].'" width="100" /></br>';
                    }
                    if($model->penjualan > 0 && Yii::$app->user->identity->id > 1){
                        echo '<li class="list-group-item">'.$img.$rowProc['nama'].'</li>';
                    }else{
                        if((int) $checkpenj > 0){
                            echo '<li class="list-group-item">'.$img.$rowProc['nama'].'</li>';
                        }else{
                            echo '<li class="list-group-item">'.$img.$rowProc['nama'].'<br> <a class="btn btn-sm btn-warning modalButton" value="'. $ud . '"> <i class="align-middle" data-feather="repeat"></i> Update</a></li>';
                        }
                    }
                }
                echo '</ul>'; 

                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';

    //Board LIST
    $modBoard = DoProdukT::find()->select(["
    do_produk.do_produk, 
    do_produk.do_produk_origin, 
    do_produk.url, 
    CASE WHEN do_produk.do_produk_origin > 0 THEN
    CONCAT(produk.nama, '<br> Label : ', produk.produk, '-', do_produk.do_produk_origin, '<br> Qty: ', do_produk.do_jml, '<br> Rp. ', FORMAT(do_produk.harga_jual, 0, 'id_ID'))
    ELSE
    CONCAT(produk.nama, '<br> Label : ', produk.produk, '-', do_produk.do_produk, '<br> Qty: ', do_produk.do_jml, '<br> Rp. ', FORMAT(do_produk.harga_jual, 0, 'id_ID'))
    END AS nama
    "])
    ->join("LEFT JOIN", "produk", "do_produk.produk=produk.produk")
    ->join("LEFT JOIN", "do", "do_produk.do=do.do")
    ->join("LEFT JOIN", "inventori", "do_produk.inventori=inventori.inventori")
    ->where(['do_produk.rakitan' => $model->rakitan, 'produk.kategori' => 20])->asArray()->all();

    echo '<div class="card m-2" style="width: 18rem;">';
        echo '<div class="row g-0">';
            echo '<div class="col-md-4">';
                echo '<img src="../assets/images/board.png" class="img-fluid rounded-start" alt="...">';
            echo '</div>';
            echo '<div class="col-md-8">';
                echo '<div class="card-body">';

                echo '<ul class="list-group list-group-flush">';
                foreach($modBoard as $rowBoard){
                    $controller = Yii::$app->controller;
                    $ud = 'index.php?r=' . $controller->id . '/out&do_produk=' . $rowBoard['do_produk'];
                    $checkpenj = PenjualanProdukT::find()
                    ->join("LEFT JOIN", "do_produk", "penjualan_produk.do_produk=do_produk.do_produk")
                    ->where(['penjualan_produk.do_produk' => $rowBoard['do_produk'], 'do_produk.rakitan' => $model->rakitan])
                    ->count();
                    $modProd = DoProdukT::findOne($rowBoard['do_produk_origin']);
                    if($modProd != null){
                        $img = '<img src="'.$modProd['url'].'" width="100" /></br>';
                    }else{
                        $img = '<img src="'.$rowBoard['url'].'" width="100" /></br>';
                    }
                    if($model->penjualan > 0 && Yii::$app->user->identity->id > 1){
                        echo '<li class="list-group-item">'.$img.$rowBoard['nama'].'</li>';
                    }else{
                        if((int) $checkpenj > 0){
                            echo '<li class="list-group-item">'.$img.$rowBoard['nama'].'</li>';
                        }else{
                            echo '<li class="list-group-item">'.$img.$rowBoard['nama'].'<br> <a class="btn btn-sm btn-warning modalButton" value="'. $ud . '"> <i class="align-middle" data-feather="repeat"></i> Update</a></li>';
                        }
                    }
                }
                echo '</ul>'; 

                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';

    //HDD LIST
    $modHdd = DoProdukT::find()->select(["
    do_produk.do_produk, 
    do_produk.do_produk_origin, 
    do_produk.url, 
    CASE WHEN do_produk.do_produk_origin > 0 THEN
    CONCAT(produk.nama, '<br> Label : ', produk.produk, '-', do_produk.do_produk_origin, '<br> Qty: ', do_produk.do_jml, '<br> Rp. ', FORMAT(do_produk.harga_jual, 0, 'id_ID'))
    ELSE
    CONCAT(produk.nama, '<br> Label : ', produk.produk, '-', do_produk.do_produk, '<br> Qty: ', do_produk.do_jml, '<br> Rp. ', FORMAT(do_produk.harga_jual, 0, 'id_ID'))
    END AS nama
    "])
    ->join("LEFT JOIN", "produk", "do_produk.produk=produk.produk")
    ->join("LEFT JOIN", "do", "do_produk.do=do.do")
    ->join("LEFT JOIN", "inventori", "do_produk.inventori=inventori.inventori")
    ->where(['do_produk.rakitan' => $model->rakitan])
    ->andWhere("produk.kategori IN ('31', '12', '11', '13', '14')")
    ->asArray()->all();

    echo '<div class="card m-2" style="width: 18rem;">';
        echo '<div class="row g-0">';
            echo '<div class="col-md-4">';
                echo '<img src="../assets/images/hdd.png" class="img-fluid rounded-start" alt="...">';
            echo '</div>';
            echo '<div class="col-md-8">';
                echo '<div class="card-body">';

                echo '<ul class="list-group list-group-flush">';
                foreach($modHdd as $rowHdd){
                    $controller = Yii::$app->controller;
                    $ud = 'index.php?r=' . $controller->id . '/out&do_produk=' . $rowHdd['do_produk'];
                    $checkpenj = PenjualanProdukT::find()
                    ->join("LEFT JOIN", "do_produk", "penjualan_produk.do_produk=do_produk.do_produk")
                    ->where(['penjualan_produk.do_produk' => $rowHdd['do_produk'], 'do_produk.rakitan' => $model->rakitan])
                    ->count();
                    $modProd = DoProdukT::findOne($rowHdd['do_produk_origin']);
                    if($modProd != null){
                        $img = '<img src="'.$modProd['url'].'" width="100" /></br>';
                    }else{
                        $img = '<img src="'.$rowHdd['url'].'" width="100" /></br>';
                    }
                    if($model->penjualan > 0 && Yii::$app->user->identity->id > 1){
                        echo '<li class="list-group-item">'.$img.$rowHdd['nama'].'</li>';
                    }else{
                        if((int) $checkpenj > 0){
                            echo '<li class="list-group-item">'.$img.$rowHdd['nama'].'</li>';
                        }else{
                            echo '<li class="list-group-item">'.$img.$rowHdd['nama'].'<br> <a class="btn btn-sm btn-warning modalButton" value="'. $ud . '"> <i class="align-middle" data-feather="repeat"></i> Update</a></li>';
                        }
                    }
                }
                echo '</ul>'; 

                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';

    //RAM LIST
    $modRam = DoProdukT::find()->select(["
    do_produk.do_produk, 
    do_produk.do_produk_origin, 
    do_produk.url, 
    CASE WHEN do_produk.do_produk_origin > 0 THEN
    CONCAT(produk.nama, '<br> Label : ', produk.produk, '-', do_produk.do_produk_origin, '<br> Qty: ', do_produk.do_jml, '<br> Rp. ', FORMAT(do_produk.harga_jual, 0, 'id_ID'))
    ELSE
    CONCAT(produk.nama, '<br> Label : ', produk.produk, '-', do_produk.do_produk, '<br> Qty: ', do_produk.do_jml, '<br> Rp. ', FORMAT(do_produk.harga_jual, 0, 'id_ID'))
    END AS nama
    "])
    ->join("LEFT JOIN", "produk", "do_produk.produk=produk.produk")
    ->join("LEFT JOIN", "do", "do_produk.do=do.do")
    ->join("LEFT JOIN", "inventori", "do_produk.inventori=inventori.inventori")
    ->where(['do_produk.rakitan' => $model->rakitan])
    ->andWhere("produk.kategori IN ('22', '21', '36')")
    ->asArray()->all();

    echo '<div class="card m-2" style="width: 18rem;">';
        echo '<div class="row g-0">';
            echo '<div class="col-md-4">';
                echo '<img src="../assets/images/ram.png" class="img-fluid rounded-start" alt="...">';
            echo '</div>';
            echo '<div class="col-md-8">';
                echo '<div class="card-body">';

                echo '<ul class="list-group list-group-flush">';
                foreach($modRam as $rowRam){
                    $controller = Yii::$app->controller;
                    $ud = 'index.php?r=' . $controller->id . '/out&do_produk=' . $rowRam['do_produk'];
                    $checkpenj = PenjualanProdukT::find()
                    ->join("LEFT JOIN", "do_produk", "penjualan_produk.do_produk=do_produk.do_produk")
                    ->where(['penjualan_produk.do_produk' => $rowRam['do_produk'], 'do_produk.rakitan' => $model->rakitan])
                    ->count();
                    $modProd = DoProdukT::findOne($rowRam['do_produk_origin']);
                    if($modProd != null){
                        $img = '<img src="'.$modProd['url'].'" width="100" /></br>';
                    }else{
                        $img = '<img src="'.$rowRam['url'].'" width="100" /></br>';
                    }
                    if($model->penjualan > 0 && Yii::$app->user->identity->id > 1){
                        echo '<li class="list-group-item">'.$img.$rowRam['nama'].'</li>';
                    }else{
                        if((int) $checkpenj > 0){
                            echo '<li class="list-group-item">'.$img.$rowRam['nama'].'</li>';
                        }else{
                            //var_dump((int) $checkpenj);die;
                            echo '<li class="list-group-item">'.$img.$rowRam['nama'].'<br> <a class="btn btn-sm btn-warning modalButton" value="'. $ud . '"> <i class="align-middle" data-feather="repeat"></i> Update</a></li>';
                        }
                    }
                }
                echo '</ul>'; 

                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';

    //VGA LIST
    $modVga = DoProdukT::find()->select(["
    do_produk.do_produk, 
    do_produk.do_produk_origin, 
    do_produk.url, 
    CASE WHEN do_produk.do_produk_origin > 0 THEN
    CONCAT(produk.nama, '<br> Label : ', produk.produk, '-', do_produk.do_produk_origin, '<br> Qty: ', do_produk.do_jml, '<br> Rp. ', FORMAT(do_produk.harga_jual, 0, 'id_ID'))
    ELSE
    CONCAT(produk.nama, '<br> Label : ', produk.produk, '-', do_produk.do_produk, '<br> Qty: ', do_produk.do_jml, '<br> Rp. ', FORMAT(do_produk.harga_jual, 0, 'id_ID'))
    END AS nama
    "])
    ->join("LEFT JOIN", "produk", "do_produk.produk=produk.produk")
    ->join("LEFT JOIN", "do", "do_produk.do=do.do")
    ->join("LEFT JOIN", "inventori", "do_produk.inventori=inventori.inventori")
    ->where(['do_produk.rakitan' => $model->rakitan, 'produk.kategori' => 34])->asArray()->all();

    echo '<div class="card m-2" style="width: 18rem;">';
        echo '<div class="row g-0">';
            echo '<div class="col-md-4">';
                echo '<img src="../assets/images/vga.png" class="img-fluid rounded-start" alt="...">';
            echo '</div>';
            echo '<div class="col-md-8">';
                echo '<div class="card-body">';

                echo '<ul class="list-group list-group-flush">';
                foreach($modVga as $rowVga){
                    $controller = Yii::$app->controller;
                    $ud = 'index.php?r=' . $controller->id . '/out&do_produk=' . $rowVga['do_produk'];
                    $checkpenj = PenjualanProdukT::find()
                    ->join("LEFT JOIN", "do_produk", "penjualan_produk.do_produk=do_produk.do_produk")
                    ->where(['penjualan_produk.do_produk' => $rowVga['do_produk'], 'do_produk.rakitan' => $model->rakitan])
                    ->count();
                    $modProd = DoProdukT::findOne($rowVga['do_produk_origin']);
                    if($modProd != null){
                        $img = '<img src="'.$modProd['url'].'" width="100" /></br>';
                    }else{
                        $img = '<img src="'.$rowVga['url'].'" width="100" /></br>';
                    }
                    if($model->penjualan > 0 && Yii::$app->user->identity->id > 1){
                        echo '<li class="list-group-item">'.$img.$rowVga['nama'].'</li>';
                    }else{
                        if((int) $checkpenj > 0){
                            echo '<li class="list-group-item">'.$img.$rowVga['nama'].'</li>';
                        }else{
                            echo '<li class="list-group-item">'.$img.$rowVga['nama'].'<br> <a class="btn btn-sm btn-warning modalButton" value="'. $ud . '"> <i class="align-middle" data-feather="repeat"></i> Update</a></li>';
                        }
                    }
                }
                echo '</ul>'; 

                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';

    //PSU LIST
    $modPSU = DoProdukT::find()->select(["
    do_produk.do_produk, 
    do_produk.do_produk_origin, 
    do_produk.url, 
    CASE WHEN do_produk.do_produk_origin > 0 THEN
    CONCAT(produk.nama, '<br> Label : ', produk.produk, '-', do_produk.do_produk_origin, '<br> Qty: ', do_produk.do_jml, '<br> Rp. ', FORMAT(do_produk.harga_jual, 0, 'id_ID'))
    ELSE
    CONCAT(produk.nama, '<br> Label : ', produk.produk, '-', do_produk.do_produk, '<br> Qty: ', do_produk.do_jml, '<br> Rp. ', FORMAT(do_produk.harga_jual, 0, 'id_ID'))
    END AS nama
    "])
    ->join("LEFT JOIN", "produk", "do_produk.produk=produk.produk")
    ->join("LEFT JOIN", "do", "do_produk.do=do.do")
    ->join("LEFT JOIN", "inventori", "do_produk.inventori=inventori.inventori")
    ->where(['do_produk.rakitan' => $model->rakitan, 'produk.kategori' => 27])->asArray()->all();

    echo '<div class="card m-2" style="width: 18rem;">';
        echo '<div class="row g-0">';
            echo '<div class="col-md-4">';
                echo '<img src="../assets/images/psu.png" class="img-fluid rounded-start" alt="...">';
            echo '</div>';
            echo '<div class="col-md-8">';
                echo '<div class="card-body">';

                echo '<ul class="list-group list-group-flush">';
                foreach($modPSU as $rowPSU){
                    $controller = Yii::$app->controller;
                    $ud = 'index.php?r=' . $controller->id . '/out&do_produk=' . $rowPSU['do_produk'];
                    $checkpenj = PenjualanProdukT::find()
                    ->join("LEFT JOIN", "do_produk", "penjualan_produk.do_produk=do_produk.do_produk")
                    ->where(['penjualan_produk.do_produk' => $rowPSU['do_produk'], 'do_produk.rakitan' => $model->rakitan])
                    ->count();
                    $modProd = DoProdukT::findOne($rowPSU['do_produk_origin']);
                    if($modProd != null){
                        $img = '<img src="'.$modProd['url'].'" width="100" /></br>';
                    }else{
                        $img = '<img src="'.$rowPSU['url'].'" width="100" /></br>';
                    }
                    if($model->penjualan > 0 && Yii::$app->user->identity->id > 1){
                        echo '<li class="list-group-item">'.$img.$rowPSU['nama'].'</li>';
                    }else{
                        if((int) $checkpenj > 0){
                            echo '<li class="list-group-item">'.$img.$rowPSU['nama'].'</li>';
                        }else{
                            echo '<li class="list-group-item">'.$img.$rowPSU['nama'].'<br> <a class="btn btn-sm btn-warning modalButton" value="'. $ud . '"> <i class="align-middle" data-feather="repeat"></i> Update</a></li>';
                        }
                    }
                }
                echo '</ul>'; 

                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';

    //CASE LIST
    $modCase = DoProdukT::find()->select(["
    do_produk.do_produk, 
    do_produk.do_produk_origin, 
    do_produk.url, 
    CASE WHEN do_produk.do_produk_origin > 0 THEN
    CONCAT(produk.nama, '<br> Label : ', produk.produk, '-', do_produk.do_produk_origin, '<br> Qty: ', do_produk.do_jml, '<br> Rp. ', FORMAT(do_produk.harga_jual, 0, 'id_ID'))
    ELSE
    CONCAT(produk.nama, '<br> Label : ', produk.produk, '-', do_produk.do_produk, '<br> Qty: ', do_produk.do_jml, '<br> Rp. ', FORMAT(do_produk.harga_jual, 0, 'id_ID'))
    END AS nama
    "])
    ->join("LEFT JOIN", "produk", "do_produk.produk=produk.produk")
    ->join("LEFT JOIN", "do", "do_produk.do=do.do")
    ->join("LEFT JOIN", "inventori", "do_produk.inventori=inventori.inventori")
    ->where(['do_produk.rakitan' => $model->rakitan])
    ->andWhere("produk.kategori IN ('5', '6')")
    ->asArray()->all();

    echo '<div class="card m-2" style="width: 18rem;">';
        echo '<div class="row g-0">';
            echo '<div class="col-md-4">';
                echo '<img src="../assets/images/casing.png" class="img-fluid rounded-start" alt="...">';
            echo '</div>';
            echo '<div class="col-md-8">';
                echo '<div class="card-body">';

                echo '<ul class="list-group list-group-flush">';
                foreach($modCase as $rowCase){
                    $controller = Yii::$app->controller;
                    $ud = 'index.php?r=' . $controller->id . '/out&do_produk=' . $rowCase['do_produk'];
                    $checkpenj = PenjualanProdukT::find()
                    ->join("LEFT JOIN", "do_produk", "penjualan_produk.do_produk=do_produk.do_produk")
                    ->where(['penjualan_produk.do_produk' => $rowCase['do_produk'], 'do_produk.rakitan' => $model->rakitan])
                    ->count();
                    $modProd = DoProdukT::findOne($rowCase['do_produk_origin']);
                    if($modProd != null){
                        $img = '<img src="'.$modProd['url'].'" width="100" /></br>';
                    }else{
                        $img = '<img src="'.$rowCase['url'].'" width="100" /></br>';
                    }
                    if($model->penjualan > 0 && Yii::$app->user->identity->id > 1){
                        echo '<li class="list-group-item">'.$img.$rowCase['nama'].'</li>';
                    }else{
                        if((int) $checkpenj > 0){
                            echo '<li class="list-group-item">'.$img.$rowCase['nama'].'</li>';
                        }else{
                            echo '<li class="list-group-item">'.$img.$rowCase['nama'].'<br> <a class="btn btn-sm btn-warning modalButton" value="'. $ud . '"> <i class="align-middle" data-feather="repeat"></i> Update</a></li>';
                        }
                    }
                }
                echo '</ul>'; 

                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';

    //Keymos LIST
    $modKeymos = DoProdukT::find()->select(["
    do_produk.do_produk, 
    do_produk.do_produk_origin, 
    do_produk.url, 
    CASE WHEN do_produk.do_produk_origin > 0 THEN
    CONCAT(produk.nama, '<br> Label : ', produk.produk, '-', do_produk.do_produk_origin, '<br> Qty: ', do_produk.do_jml, '<br> Rp. ', FORMAT(do_produk.harga_jual, 0, 'id_ID'))
    ELSE
    CONCAT(produk.nama, '<br> Label : ', produk.produk, '-', do_produk.do_produk, '<br> Qty: ', do_produk.do_jml, '<br> Rp. ', FORMAT(do_produk.harga_jual, 0, 'id_ID'))
    END AS nama
    "])
    ->join("LEFT JOIN", "produk", "do_produk.produk=produk.produk")
    ->join("LEFT JOIN", "do", "do_produk.do=do.do")
    ->join("LEFT JOIN", "inventori", "do_produk.inventori=inventori.inventori")
    ->where(['do_produk.rakitan' => $model->rakitan])
    ->andWhere("produk.kategori IN ('17', '24', '39', '47')")
    ->asArray()->all();

    echo '<div class="card m-2" style="width: 18rem;">';
        echo '<div class="row g-0">';
            echo '<div class="col-md-4">';
                echo '<img src="../assets/images/keyboard.png" class="img-fluid rounded-start" alt="...">';
            echo '</div>';
            echo '<div class="col-md-8">';
                echo '<div class="card-body">';

                echo '<ul class="list-group list-group-flush">';
                foreach($modKeymos as $rowKeymos){
                    $controller = Yii::$app->controller;
                    $ud = 'index.php?r=' . $controller->id . '/out&do_produk=' . $rowKeymos['do_produk'];
                    $checkpenj = PenjualanProdukT::find()
                    ->join("LEFT JOIN", "do_produk", "penjualan_produk.do_produk=do_produk.do_produk")
                    ->where(['penjualan_produk.do_produk' => $rowKeymos['do_produk'], 'do_produk.rakitan' => $model->rakitan])
                    ->count();
                    $modProd = DoProdukT::findOne($rowKeymos['do_produk_origin']);
                    if($modProd != null){
                        $img = '<img src="'.$modProd['url'].'" width="100" /></br>';
                    }else{
                        $img = '<img src="'.$rowKeymos['url'].'" width="100" /></br>';
                    }
                    if($model->penjualan > 0 && Yii::$app->user->identity->id > 1){
                        echo '<li class="list-group-item">'.$img.$rowKeymos['nama'].'</li>';
                    }else{
                        if((int) $checkpenj > 0){
                            echo '<li class="list-group-item">'.$img.$rowKeymos['nama'].'</li>';
                        }else{
                            echo '<li class="list-group-item">'.$img.$rowKeymos['nama'].'<br> <a class="btn btn-sm btn-warning modalButton" value="'. $ud . '"> <i class="align-middle" data-feather="repeat"></i> Update</a></li>';
                        }
                    }
                }
                echo '</ul>'; 

                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';

    //Other LIST
    $modOther = DoProdukT::find()->select(["
    do_produk.do_produk, 
    do_produk.do_produk_origin, 
    do_produk.url, 
    CASE WHEN do_produk.do_produk_origin > 0 THEN
    CONCAT(produk.nama, '<br> Label : ', produk.produk, '-', do_produk.do_produk_origin, '<br> Qty: ', do_produk.do_jml, '<br> Rp. ', FORMAT(do_produk.harga_jual, 0, 'id_ID'))
    ELSE
    CONCAT(produk.nama, '<br> Label : ', produk.produk, '-', do_produk.do_produk, '<br> Qty: ', do_produk.do_jml, '<br> Rp. ', FORMAT(do_produk.harga_jual, 0, 'id_ID'))
    END AS nama
    "])
    ->join("LEFT JOIN", "produk", "do_produk.produk=produk.produk")
    ->join("LEFT JOIN", "do", "do_produk.do=do.do")
    ->join("LEFT JOIN", "inventori", "do_produk.inventori=inventori.inventori")
    ->where(['do_produk.rakitan' => $model->rakitan])
    ->andWhere("produk.kategori NOT IN ('17', '24', '39', '47', '17', '24', '39', '47', '5', '6', '27', '34', '22', '21', '36', '31', '12', '11', '13', '14', '20', '29', '10', '32', '23')")
    ->asArray()->all();

    echo '<div class="card m-2" style="width: 18rem;">';
        echo '<div class="row g-0">';
            echo '<div class="col-md-4">';
                echo '<h4><b> Acc + Other </b></h4>';
            echo '</div>';
            echo '<div class="col-md-8">';
                echo '<div class="card-body">';

                echo '<ul class="list-group list-group-flush">';
                foreach($modOther as $rowOther){
                    $controller = Yii::$app->controller;
                    $ud = 'index.php?r=' . $controller->id . '/out&do_produk=' . $rowOther['do_produk'];
                    $checkpenj = PenjualanProdukT::find()
                    ->join("LEFT JOIN", "do_produk", "penjualan_produk.do_produk=do_produk.do_produk")
                    ->where(['penjualan_produk.do_produk' => $rowOther['do_produk'], 'do_produk.rakitan' => $model->rakitan])
                    ->count();
                    $modProd = DoProdukT::findOne($rowOther['do_produk_origin']);
                    if($modProd != null){
                        $img = '<img src="'.$modProd['url'].'" width="100" /></br>';
                    }else{
                        $img = '<img src="'.$rowOther['url'].'" width="100" /></br>';
                    }
                    if($model->penjualan > 0 && Yii::$app->user->identity->id > 1){
                        echo '<li class="list-group-item">'.$img.$rowOther['nama'].'</li>';
                    }else{
                        if((int) $checkpenj > 0){
                            echo '<li class="list-group-item">'.$img.$rowOther['nama'].'</li>';
                        }else{
                            echo '<li class="list-group-item">'.$img.$rowOther['nama'].'<br> <a class="btn btn-sm btn-warning modalButton" value="'. $ud . '"> <i class="align-middle" data-feather="repeat"></i> Update</a></li>';
                        }
                    }
                }
                echo '</ul>'; 

                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
?>

</div>

<div class="row p-3">
    <div class="col-md-12 bg-light p-3"><?php 
        if($model->penjualan > 0){
            echo '<b> Status: Sold <a href="'.Url::to(['penjualan/update', 'penjualan' => $model->penjualan]).'" class="btn btn-sm btn-success" target="_blank">' . $model->penjualan0->faktur . '</a></b> <small><i>*jika rakitan status sudah ada no.penjualan dan di list item rakitan ada yang bisa di update, berarti item rakitan di out dari penjualan.</i></small>';
        }
        ?></b><br><hr>
        <b> Total Jenis Item di rakitan: <?php echo DoProdukT::find()->where(['rakitan' => $model->rakitan])->count(); ?></b><br><hr>
        <b> Total HPP: <?php  
        $total2 = DoProdukT::find()->select(['SUM(do_jml*do_harga) AS total'])->where(['rakitan' => $model->rakitan])->asArray()->one();
        if($total2 != null){
        echo '<div class="row">'; 
            echo '<div class="col-md-6 text-left">'; 
            echo '<i>' . MyFormatter::formatNumberTerbilang( (int) $total2['total']) . ' rupiah </i>';
            echo '</div>';
            echo '<div class="col-md-6 text-right">'; 
            echo MyFormatter::formatUang((int) $total2['total']);
            echo '</div>';
        echo '</div>';
        }
        ?>
        </b><br><hr>
        <b> Total Selling Value: <?php  
        $total = DoProdukT::find()->select(['SUM(do_jml*harga_jual) AS total'])->where(['rakitan' => $model->rakitan])->asArray()->one();
        if($total != null){
        echo '<div class="row">'; 
            echo '<div class="col-md-6 text-left">'; 
            echo '<i>' . MyFormatter::formatNumberTerbilang( (int) $total['total']) . ' rupiah </i>';
            echo '</div>';
            echo '<div class="col-md-6 text-right">'; 
            echo MyFormatter::formatUang((int) $total['total']);
            echo '</div>';
        echo '</div>';
        }
        ?>
        </b><br><hr>
        <b> Margin Value: <?php  
        if($total != null && $total2 != null){
            $margin = (int) $total['total'] - (int) $total2['total'];
        echo '<div class="row">'; 
            echo '<div class="col-md-6 text-left">'; 
            echo '<i>' . MyFormatter::formatNumberTerbilang($margin) . ' rupiah </i>';
            echo '</div>';
            echo '<div class="col-md-6 text-right">'; 
            echo MyFormatter::formatUang($margin);
            echo '</div>';
        echo '</div>';
        }
        ?>
        </b>
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
        $('#modal').modal({
            backdrop: 'static',
            keyboard: false
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
<?php

/* @var $this \yii\web\View */
/* @var $content string */

namespace app\components;

use yii;
use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use app\models\Divisi;
//check access
$divisi = Yii::$app->user->identity->divisi;

$queryD = Divisi::findOne($divisi);
$divisiName = $queryD->nama;

$current_modul = Yii::$app->controller->id;

if($current_modul === 'penjualan' || $current_modul === 'penjualan/update' || $current_modul === 'penjualan/create' || $current_modul === 'penjualan/insertPenjualanProduk' || $current_modul === 'penjualan/delete' || $current_modul === 'penjualan/view' || $current_modul === 'penjualan/upload' || $current_modul === 'penjualan/manifest' || $current_modul === 'penjualan/deleteFile' || $current_modul === 'penjualan/deleteNota'){
    $accessArray = [1,2,3,5];
}elseif($current_modul === 'variable' || $current_modul === 'variable/update' || $current_modul === 'variable/create' || $current_modul === 'variable/delete'){
    $accessArray = [1,2];
}elseif($current_modul === 'order'){
    $accessArray = [1,2,5];
}elseif($current_modul === 'pembelian' || $current_modul === 'pembelian/update' || $current_modul === 'pembelian/create' || $current_modul === 'pembelian/delete' || $current_modul === 'pembelian/view'){
    $accessArray = [1,2,3];
}elseif($current_modul === 'divisi' || $current_modul === 'divisi/update' || $current_modul === 'divisi/create' || $current_modul === 'divisi/delete' || $current_modul === 'divisi/view'){
    $accessArray = [1,2];
}elseif($current_modul === 'konsumen' || $current_modul === 'konsumen/update' || $current_modul === 'konsumen/create' || $current_modul === 'konsumen/delete' || $current_modul === 'konsumen/view'){
    $accessArray = [1,2,3,5];
}elseif($current_modul === 'supplier' || $current_modul === 'supplier/update' || $current_modul === 'supplier/create' || $current_modul === 'supplier/delete' || $current_modul === 'supplier/view'){
    $accessArray = [1,2,3];
}elseif($current_modul === 'produk' || $current_modul === 'produk/update' || $current_modul === 'produk/create' || $current_modul === 'produk/delete' || $current_modul === 'produk/view'){
    $accessArray = [1,2,3];
}elseif($current_modul === 'backend-user' || $current_modul === 'backend-user/update' || $current_modul === 'backend-user/create' || $current_modul === 'backend-user/delete' || $current_modul === 'backend-user/view' || $current_modul === 'backend-user/changePassword'){
    $accessArray = [1,2];
}elseif($current_modul === 'akun' || $current_modul === 'akun/update' || $current_modul === 'akun/create' || $current_modul === 'akun/delete' || $current_modul === 'akun/view'){
    $accessArray = [1,2];
}elseif($current_modul === 'penjualan-produk-step' || $current_modul === 'penjualan-produk-step/update' || $current_modul === 'penjualan-produk-step/create' || $current_modul === 'penjualan-produk-step/delete' || $current_modul === 'penjualan-produk-step/view'){
    $accessArray = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17];
}elseif($current_modul === 'tracking-order' || $current_modul === 'tracking-order/update' || $current_modul === 'tracking-order/create' || $current_modul === 'tracking-order/delete' || $current_modul === 'tracking-order/view'){
    $accessArray = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17];
}elseif($current_modul === 'pembayaran-penjualan' || $current_modul === 'pembayaran-penjualan/update' || $current_modul === 'pembayaran-penjualan/create' || $current_modul === 'pembayaran-penjualan/delete' || $current_modul === 'pembayaran-penjualan/view'){
    $accessArray = [1,2,3,5];
}else{
    $accessArray = [];
}
//
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <link rel="icon" type="image/ico" href="../assets/images/LOGOW.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
    html
    {
        font-size: 90% !important;
    }
    body
    {
        font-family: "Helvetica" !important;
    }
    .bg-info {
        background: #f84e4e !important; 
    }
    </style>
    <!-- <script type="text/javascript" src="../assets/js/jquery-3.5.1.js"></script> -->
    <link media="screen" rel="stylesheet" href="../web/css/app.css">
    <link media="print" rel="stylesheet" href="../web/css/app.css">
    <link media="screen" rel="stylesheet" href="../assets/fontawesome5/css/all.css">
    <link media="screen" rel="stylesheet" href="../web/css/bootstrap-table.min.css">
    <link media="screen" rel="stylesheet" href="../web/css/bootstrap-table-group-by.css">
    <script src="../assets/js/jquery-3.5.1.js"></script>
    <script src="../assets/js/jquery-ui.js"></script>
    <script src="../assets/fontawesome5/js/all.js"></script>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>


<?php
//If allow access
if(in_array($divisi, $accessArray) > 0){ ?>

<div class="container-flex p-1">
    <?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs'])? $this->params['breadcrumbs'] : [],
    'homeLink' => false
    ]) ?>
    <?= Alert::widget() ?>
    <?= $content ?>
</div>
<?php }else{
//If not allow access
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
            <h3>Akses untuk divisi lain</h3>
            <p class="lead">Login sesuai divisi.</p>
        
    </div>
</div>
<?php } ?>

</main>

</div>
<?php $this->endBody() ?>
<script src="../assets/js/app.js"></script>
<script src="../assets/js/bootstrap-table.min.js"></script>
<script src="../assets/js/bootstrap-table-export.min.js"></script>
<script src="../assets/js/bootstrap-table-filter-control.min.js"></script>
<script src="../assets/js/bootstrap-table-group-by.min.js"></script>
<script src="../assets/js/bootstrap-table-mobile.min.js"></script>
</body>
</html>
<?php $this->endPage() ?>

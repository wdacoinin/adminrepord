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
/* use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this); */

include Yii::$app->basePath.'/views/layouts/menu.php';

if(Yii::$app->user->identity){
AppAsset::register($this);
//check access
    $divisi = Yii::$app->user->identity->divisi;

    $queryD = Divisi::findOne($divisi);
    $divisiName = $queryD->nama;

    $current_modul = Yii::$app->controller->id;

    if($current_modul === 'penjualan' || $current_modul === 'penjualan/update' || $current_modul === 'penjualan/create' || $current_modul === 'penjualan/insertPenjualanProduk' || $current_modul === 'penjualan/delete' || $current_modul === 'penjualan/view' || $current_modul === 'penjualan/upload' || $current_modul === 'penjualan/manifest' || $current_modul === 'penjualan/deleteFile' || $current_modul === 'penjualan/deleteNota'){
        $accessArray = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17];
    }elseif($current_modul === 'variable' || $current_modul === 'variable/update' || $current_modul === 'variable/create' || $current_modul === 'variable/delete'){
        $accessArray = [1,2];
    }elseif($current_modul === 'pembelian-view'){
        $accessArray = [1,2,3];
    }elseif($current_modul === 'do-produk/global'){
        $accessArray = [1,2,3,4,5,6];
    }elseif($current_modul === 'update-stok'){
        $accessArray = [1,2,3];
    }elseif($current_modul === 'akun-saldo' || $current_modul === 'akun-saldo/update' || $current_modul === 'akun-saldo/create' || $current_modul === 'akun-saldo/delete' || $current_modul === 'akun-saldo/view' || $current_modul === 'akun-saldo/transaksi'){
        $accessArray = [1,2,3];
    }elseif($current_modul === 'akun-saldo/view' || $current_modul === 'akun-saldo/transaksi'){
        $accessArray = [1,2];
    }elseif($current_modul === 'penjualan-kotor'){
        $accessArray = [1,2];
    }elseif($current_modul === 'board'){
        $accessArray = [1,2];
    }elseif($current_modul === 'absen'){
        $accessArray = [1];
    }elseif($current_modul === 'salary'){
        $accessArray = [1];
    }elseif($current_modul === 'neraca'){
        $accessArray = [1];
    }elseif($current_modul === 'margin'){
        $accessArray = [1];
    } elseif ($current_modul === 'inventori' || $current_modul === 'inventori/update' || $current_modul === 'inventori/create' || $current_modul === 'inventori/delete' || $current_modul === 'inventori/view') {
        $accessArray = [1, 2, 3];
    } elseif ($current_modul === 'lokasi' || $current_modul === 'lokasi/update' || $current_modul === 'lokasi/create' || $current_modul === 'lokasi/delete' || $current_modul === 'lokasi/view') {
        $accessArray = [1, 2, 3];
    } elseif ($current_modul === 'rakitan' || $current_modul === 'rakitan/update' || $current_modul === 'rakitan/create' || $current_modul === 'rakitan/delete' || $current_modul === 'rakitan/view' || $current_modul === 'rakitan/rakitansold') {
        $accessArray = [1, 2, 3];
    } elseif ($current_modul === 'wo' || $current_modul === 'wo/update' || $current_modul === 'wo/create' || $current_modul === 'wo/delete' || $current_modul === 'wo/view') {
        $accessArray = [1, 2, 3];
    }elseif($current_modul === 'beban-jenis' || $current_modul === 'beban-jenis/update' || $current_modul === 'beban-jenis/create' || $current_modul === 'beban-jenis/delete' || $current_modul === 'beban-jenis/view'){
        $accessArray = [1,2,3];
    }elseif($current_modul === 'beban' || $current_modul === 'beban/update' || $current_modul === 'beban/create' || $current_modul === 'beban/delete' || $current_modul === 'beban/view'){
        $accessArray = [1,2,3];
    }elseif($current_modul === 'aktiva' || $current_modul === 'aktiva' || $current_modul === 'aktiva/create' || $current_modul === 'aktiva/delete' || $current_modul === 'aktiva/view'){
        $accessArray = [1,2,3];
    }elseif($current_modul === 'kategori' || $current_modul === 'kategori/update' || $current_modul === 'kategori/create' || $current_modul === 'kategori/delete'){
        $accessArray = [1,2,3];
    }elseif($current_modul === 'stok-jenis' || $current_modul === 'stok-jenis/update' || $current_modul === 'stok-jenis/create' || $current_modul === 'stok-jenis/delete'){
        $accessArray = [1,2,3];
    }elseif($current_modul === 'order'){
        $accessArray = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17];
    }elseif($current_modul === 'download-apk'){
        $accessArray = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17];
    }elseif($current_modul === 'dop' || $current_modul === 'dop/update' || $current_modul === 'dop/create' || $current_modul === 'dop/delete' || $current_modul === 'dop/view'){
        $accessArray = [1,2];
    }elseif($current_modul === 'do-produk' || $current_modul === 'do-produk/update' || $current_modul === 'do-produk/create' || $current_modul === 'do-produk/delete' || $current_modul === 'do-produk/view' || $current_modul === 'do-produk/global' || $current_modul === 'do-produk/stokterjual'){
        $accessArray = [1,2,3];
    }elseif($current_modul === 'rma' || $current_modul === 'rma/update' || $current_modul === 'rma/create' || $current_modul === 'rma/delete' || $current_modul === 'rma/view'){
        $accessArray = [1,2];
    }elseif($current_modul === 'dopembelian'){
        $accessArray = [1,2];
    }elseif($current_modul === 'divisi' || $current_modul === 'divisi/update' || $current_modul === 'divisi/create' || $current_modul === 'divisi/delete' || $current_modul === 'divisi/view'){
        $accessArray = [1,2];
    }elseif($current_modul === 'retur' || $current_modul === 'retur/update' || $current_modul === 'retur/create' || $current_modul === 'retur/delete' || $current_modul === 'retur/view'){
        $accessArray = [1,2];
    }elseif($current_modul === 'konsumen' || $current_modul === 'konsumen/update' || $current_modul === 'konsumen/create' || $current_modul === 'konsumen/delete' || $current_modul === 'konsumen/view'){
        $accessArray = [1,2,3,5,6,7,8,9,10,11,12,13,14,15,16,17];
    }elseif($current_modul === 'konsumen/delete'){
        $accessArray = [1,2,3,5];
    }elseif($current_modul === 'supplier' || $current_modul === 'supplier/update' || $current_modul === 'supplier/create' || $current_modul === 'supplier/delete' || $current_modul === 'supplier/view'){
        $accessArray = [1,2,3];
    }elseif($current_modul === 'pengiriman' || $current_modul === 'pengiriman/update' || $current_modul === 'pengiriman/create' || $current_modul === 'pengiriman/delete' || $current_modul === 'pengiriman/view'){
        $accessArray = [1,2,3];
    }elseif($current_modul === 'produk' || $current_modul === 'produk/update' || $current_modul === 'produk/create' || $current_modul === 'produk/delete' || $current_modul === 'produk/view'){
        $accessArray = [1,2,3];
    }elseif($current_modul === 'backend-user/create' || $current_modul === 'backend-user/delete' || $current_modul === 'backend-user/view' || $current_modul === 'backend-user/viewmobile'){
        $accessArray = [1,2];
    }elseif($current_modul === 'backend-user' || $current_modul === 'backend-user/viewmobile'){
        $accessArray = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17];
    }elseif($current_modul === 'backend-user/update' || $current_modul === 'backend-user/changePassword'){
        $accessArray = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17];
    }elseif($current_modul === 'akun' || $current_modul === 'akun/update' || $current_modul === 'akun/create' || $current_modul === 'akun/delete' || $current_modul === 'akun/view'){
        $accessArray = [1,2,3];
    }elseif($current_modul === 'merek' || $current_modul === 'merek/update' || $current_modul === 'merek/create' || $current_modul === 'merek/delete' || $current_modul === 'merek/view'){
        $accessArray = [1,2,3,5,6,7,8,9,10,11,12,13,14,15,16,17];
    }elseif($current_modul === 'tracking-order' || $current_modul === 'tracking-order/update' || $current_modul === 'tracking-order/create' || $current_modul === 'tracking-order/delete' || $current_modul === 'tracking-order/view' || $current_modul === 'tracking-order/viewmobile'){
        $accessArray = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17];
    }elseif($current_modul === 'pembayaran-penjualan' || $current_modul === 'pembayaran-penjualan/update' || $current_modul === 'pembayaran-penjualan/create' || $current_modul === 'pembayaran-penjualan/delete' || $current_modul === 'pembayaran-penjualan/view'){
        $accessArray = [1,2,3,5];
    }elseif($current_modul === 'pembayaran-pembelian' || $current_modul === 'pembayaran-pembelian/update' || $current_modul === 'pembayaran-pembelian/create' || $current_modul === 'pembayaran-pembelian/delete' || $current_modul === 'pembayaran-pembelian/view'){
        $accessArray = [1,2,3,5];
    }elseif($current_modul === 'report' || $current_modul === 'report/update' || $current_modul === 'report/create' || $current_modul === 'report/delete' || $current_modul === 'report/view'){
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
    .table td,
    .table th {
        font-size: 11px;
    }
    .table td {
        color: #000;
    }
    .sidebar-brand {
        color: #343434 !important;	
    }
        .sidebar-brand .row-cols-auto>*{
            align-self: center;
        }
    .sidebar-link, a.sidebar-link, a.sidebar-link svg {
        /*background: #f9f9f9 !important;*/
        color: #343434 !important;
    }
    .sidebar-link, a.sidebar-link:hover, a.sidebar-link svg:hover {
        color: #000 !important;
    }
    .fixed-table-toolbar{
            background: #3c5e8f;
    }
    .avatar {
        height: auto !important;
    }
    /* .navbar-collapse {
        width: auto;
    } */
    .bg-info {
        background: #3c5e8f !important; 
    }
    .modal h1{
        font-size: 12px !important;
        font-weight: bold;
    }
    .kv-grid-table td,
    .kv-grid-table tr {
        padding-top:3px !important;
        padding-bottom:3px !important;
    }
	.alert,
	.alert .close{
		padding: .35rem !important;
	}
    </style>
    <!-- <script type="text/javascript" src="../assets/js/jquery-3.5.1.js"></script> -->
    <link media="screen" rel="stylesheet" href="../web/css/app.css">
    <link media="screen" rel="stylesheet" href="../assets/fontawesome5/css/all.css">
    <link media="screen" rel="stylesheet" href="../web/css/bootstrap-table.min.css">
    <link media="screen" rel="stylesheet" href="../web/css/bootstrap-table-group-by.css">
    <script src="../assets/js/jquery-3.5.1.js"></script>
    <script src="../assets/js/jquery-ui.js"></script>
    <script src="../assets/fontawesome5/js/all.js"></script>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<div class="wrapper">
	
<nav id="sidebar" class="sidebar d-print-none" style="background: #ffffff !important;">
	<!-- Sidebar Header -->
	<div class="sidebar-content js-simplebar" style="background: transparent !important;">
	<a class="sidebar-brand" style="background: #f2f2f2; border-top:1px solid #eaeaea;" href="#">
		<span class="row row-cols-auto g-1">
			<div class="col">
				<img src="../assets/images/LOGO.png" class="avatar" alt="#">
			</div> 
			<div class="col gx-3" style="font-size:12px !important;font-weight:500">
			MJ Teknologi <br>
			<small class="text-secondary"><i>Semarang</i></small>
			</div> 
		</span>						
	</a>
	    <ul class="sidebar-nav">

        <?php menu_list($divisi, $divisiName); ?>

        </ul>
	
        <div class="p-2 text-secondary bg-light" style="border-top:1px solid #eaeaea;bottom:0;text-align:center;align-items:center;">
            <div class="container">
                <p class="float-left">&copy; <?php echo Yii::$app->name; ?> <?= date('Y') ?> Rev 2.0</p>
                <!-- <p class="float-right"><?= Yii::powered() ?></p> -->
            </div>
        </div>
	</div>
</nav>
<main role="main" class="main" style="background:#ffffff;">

    <nav class="navbar navbar-expand navbar-light navbar-bg d-print-none">
        <a class="sidebar-toggle d-flex">
        <i class="hamburger align-self-center"></i>
        </a>
        <!-- <div id="marquee" class="d-flex">
            <div id="text">Messages Board</div>
        </div> -->
        <div class="navbar-collapse collapse">
            <ul class="navbar-nav navbar-align">
                <li class="nav-item dropdown">
                    <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
                        <i class="align-middle" data-feather="settings"></i>
                    </a>

                    <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
                    <?php if(Yii::$app->user->identity->size > 0){ ?>
                        <img src="<?php echo Yii::$app->user->identity->url; ?>" class="avatar img-fluid rounded mr-1 d-print-none" /> <span class="align-middle"><?php //echo ucfirst($_SESSION['nama_pemakai']); ?></span>
                    <?php }else{ ?>
                        <img src="../assets/images/user.png" class="avatar img-fluid rounded mr-1 d-print-none" /> <span class="align-middle"><?php //echo ucfirst($_SESSION['nama_pemakai']); ?></span>
                    <?php } ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right d-print-none">
                        <a class="dropdown-item" href="index.php?r=backend-user%2Fupdateauser&id=<?php echo Yii::$app->user->identity->id; ?>"><i class="align-middle" data-feather="user"></i>  <span class="align-middle"><?php echo ucfirst(Yii::$app->user->identity->nama); ?></span></a>
                        <!-- <a class="dropdown-item" href="../adm/profile.php"><i class="align-middle mr-1" data-feather="user"></i> Profile</a> -->
                        <!-- <div class="dropdown-divider"></div> -->
                        <?php echo '<a class="dropdown-item"><span class="align-middle">'
                        . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                        . Html::submitButton(
                            'Keluar (' . Yii::$app->user->identity->username . ')',
                            ['class' => 'btn btn-sm logout']
                        )
                        . Html::endForm()
                        . '</span></a>'; ?>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

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

<?php }
}else{
    Yii::$app->getResponse()->redirect('/backend/web')->send();
    exit(0);
} ?>

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

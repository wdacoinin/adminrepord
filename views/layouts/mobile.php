<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <link rel="icon" type="image/ico" href="../assets/images/LOGOW.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
    <link rel="stylesheet" media="screen" href="../web/css/style.css">
    <!-- <script src="../assets/js/jquery-3.5.1.js"></script> -->
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <!-- <script type="text/javascript" src="../assets/js/jquery-3.5.1.js"></script> -->
    <link media="screen" rel="stylesheet" href="../web/css/app.css">
    <link media="screen" rel="stylesheet" href="../assets/fontawesome5/css/all.css">
    <link media="screen" rel="stylesheet" href="../web/css/jquery-ui.css">
    <link media="screen" rel="stylesheet" href="../web/css/all.min.css">
    <link media="screen" rel="stylesheet" href="../web/css/bootstrap-table.min.css">
    <link media="screen" rel="stylesheet" href="../web/css/bootstrap-table-group-by.css">
    <script src="../assets/js/jquery-3.5.1.js"></script>
    <script src="../assets/js/tableExport.min.js"></script>
    <script src="../assets/js/bootstrap-table.min.js"></script>
    <script src="../assets/js/bootstrap-table-export.min.js"></script>
    <script src="../assets/js/all.min.js"></script>
    <script src="../assets/js/jquery-ui.js"></script>
    <script src="../assets/fontawesome5/js/all.js"></script>
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
        font-size: 11px !important;
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
        background: #f9f9f9 !important;
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
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>


<main role="main" class="flex-shrink-0">
    <div class="container-flex">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<?php $this->endBody() ?>
<script src="../assets/js/app.js"></script>
</body>
</html>
<?php $this->endPage() ?>

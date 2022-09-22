<?php

//namespace app\controllers;

use app\models\DivisiT;
use app\models\Divisi;

/* @var $this yii\web\View */
$this->title = 'MJ Teknologi Semarang';
if(!Yii::$app->user->isGuest){
    $divisi = Divisi::findOne(Yii::$app->user->identity->divisi);
}
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <?php if(!Yii::$app->user->isGuest){ ?>
            <h3>Selamat datang di aplikasi MJ Teknologi Semarang</h3>
            <p class="lead">Login Untuk menggunakan Aplikasi.</p>
        <?php }else{ ?>
            <h3>Selamat datang <?php echo Yii::$app->user->identity->nama ?> di aplikasi MJ Teknologi Semarang</h3>
            <p class="lead">Divisi anda <?php echo $divisi->nama ?> Pilih Modul untuk kelola.</p>
        <?php } ?>
        
    </div>
</div>

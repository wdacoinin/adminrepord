<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanT */

$this->title = 'Update Penjualan: ' . $model->faktur;
$this->params['breadcrumbs'][] = ['label' => 'Penjualan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->faktur];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="penjualan-t-update">

    <?= $this->render('_formupdate', [
        'model' => $model,
        'modTotal' => $modTotal,
        'DocPenj' => $DocPenj,
        'DocKonsumen' => $DocKonsumen,
        'DocBarang' => $DocBarang,
        'DocTransaksi' => $DocTransaksi,
        'searchModel2' => $searchModel2, 
        'dataProvider2' => $dataProvider2,
        'searchModel3' => $searchModel3,
        'dataProvider3' => $dataProvider3,
        'searchModel4' => $searchModel4,
        'dataProvider4' => $dataProvider4,
    ]) ?>

</div>

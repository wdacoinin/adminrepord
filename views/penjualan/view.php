<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanT */

$this->title = $model->penjualan;
$this->params['breadcrumbs'][] = ['label' => 'Penjualan Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="penjualan-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'penjualan' => $model->penjualan], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'penjualan' => $model->penjualan], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'penjualan',
            'penjualan_tgl',
            'penjualan_tempo',
            'konsumen',
            'faktur',
            'surat_jalan',
            'keterangan:ntext',
            'penjualan_ongkir',
            'fee',
            'fee_date',
            'sales',
            'penjualan_diskon',
            'user',
            'penjualan_status',
            'akun',
            'total_bahan',
        ],
    ]) ?>

</div>

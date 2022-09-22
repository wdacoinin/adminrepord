<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DoProdukT */

$this->title = $model->do_produk;
$this->params['breadcrumbs'][] = ['label' => 'Do Produk Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="do-produk-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'do_produk' => $model->do_produk], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'do_produk' => $model->do_produk], [
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
            'do_produk',
            'do',
            'stok_jenis',
            'produk',
            'do_jml',
            'do_harga',
            'harga_jual',
            'do_produk_status',
            'jml_now',
            'do_produk_date',
            'do_produk_date_stok',
            'timestamp',
        ],
    ]) ?>

</div>

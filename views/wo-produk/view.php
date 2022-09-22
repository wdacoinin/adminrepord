<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\WoProdukT */

$this->title = $model->wo_produk;
$this->params['breadcrumbs'][] = ['label' => 'Wo Produk Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="wo-produk-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'wo_produk' => $model->wo_produk], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'wo_produk' => $model->wo_produk], [
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
            'wo_produk',
            'wo',
            'produk',
            'do_produk',
            'wo_jml',
            'wo_hpp',
            'wo_harga',
            'user_input',
            'timestamp',
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProdukT */

$this->title = $model->produk;
$this->params['breadcrumbs'][] = ['label' => 'Produk Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="produk-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'produk' => $model->produk], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'produk' => $model->produk], [
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
            'produk',
            'nama',
            'kategori',
            'merek',
            'status',
        ],
    ]) ?>

</div>

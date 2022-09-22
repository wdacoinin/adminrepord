<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RmaItemT */

$this->title = $model->rma_item;
$this->params['breadcrumbs'][] = ['label' => 'Rma Item Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="rma-item-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'rma_item' => $model->rma_item], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'rma_item' => $model->rma_item], [
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
            'rma_item',
            'rma',
            'produk',
            'rma_jml',
            'rma_harga',
            'rma_ket:ntext',
            'nama_foto',
            'type',
            'size',
            'url:url',
            'id_user',
            'timestamp',
        ],
    ]) ?>

</div>

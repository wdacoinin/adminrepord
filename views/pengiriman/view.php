<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PengirimanT */

$this->title = $model->pengiriman;
$this->params['breadcrumbs'][] = ['label' => 'Pengiriman Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pengiriman-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'pengiriman' => $model->pengiriman], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'pengiriman' => $model->pengiriman], [
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
            'pengiriman',
            'surat_jalan',
            'user',
            'nama_penerima',
            'cp',
            'Alamat:ntext',
            'datetime',
            'nama_foto',
            'type',
            'size',
            'url:url',
        ],
    ]) ?>

</div>

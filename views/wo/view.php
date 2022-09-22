<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\WoT */

$this->title = $model->wo;
$this->params['breadcrumbs'][] = ['label' => 'Wo Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="wo-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'wo' => $model->wo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'wo' => $model->wo], [
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
            'wo',
            'status',
            'penjualan',
            'nama_foto',
            'type',
            'url:url',
            'size',
            'id_user',
            'konsumen',
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\KonsumenT */

$this->title = $model->konsumen;
$this->params['breadcrumbs'][] = ['label' => 'Konsumen Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="konsumen-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'konsumen' => $model->konsumen], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'konsumen' => $model->konsumen], [
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
            'konsumen',
            'konsumen_nama',
            'konsumen_telp',
            'alamat:ntext',
            'timestamp',
        ],
    ]) ?>

</div>

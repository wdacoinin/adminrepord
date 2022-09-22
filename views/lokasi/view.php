<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LokasiT */

$this->title = $model->lokasi;
$this->params['breadcrumbs'][] = ['label' => 'Lokasi Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="lokasi-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'lokasi' => $model->lokasi], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'lokasi' => $model->lokasi], [
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
            'lokasi',
            'nama',
            'detail',
        ],
    ]) ?>

</div>

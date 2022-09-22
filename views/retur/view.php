<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ReturT */

$this->title = $model->retur;
$this->params['breadcrumbs'][] = ['label' => 'Retur Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="retur-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'retur' => $model->retur], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'retur' => $model->retur], [
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
            'retur',
            'do',
            'noretur',
            'date',
            'user',
            'retur_status',
            'nama_foto',
            'type',
            'size',
            'url:url',
        ],
    ]) ?>

</div>

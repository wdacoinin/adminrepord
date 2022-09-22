<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RmaT */

$this->title = $model->rma;
$this->params['breadcrumbs'][] = ['label' => 'Rma Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="rma-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'rma' => $model->rma], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'rma' => $model->rma], [
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
            'rma',
            'rma_status',
            'rma_nota',
            'nama_foto',
            'type',
            'url:url',
            'size',
            'id_user',
            'konsumen',
            'rma_date',
        ],
    ]) ?>

</div>

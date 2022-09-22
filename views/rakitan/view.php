<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RakitanT */

$this->title = $model->rakitan;
$this->params['breadcrumbs'][] = ['label' => 'Rakitan Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="rakitan-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'rakitan' => $model->rakitan], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'rakitan' => $model->rakitan], [
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
            'rakitan',
            'inventori',
            'status',
            'penjualan',
            'nama_foto',
            'type',
            'url:url',
            'id_user',
        ],
    ]) ?>

</div>

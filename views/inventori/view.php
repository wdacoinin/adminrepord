<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\InventoriT */

$this->title = $model->inventori;
$this->params['breadcrumbs'][] = ['label' => 'Inventori Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="inventori-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'inventori' => $model->inventori], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'inventori' => $model->inventori], [
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
            'inventori',
            'lokasi',
            'kode',
        ],
    ]) ?>

</div>

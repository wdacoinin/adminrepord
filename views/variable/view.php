<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VariableT */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'MJ Teknologi Semarang Setting', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="variable-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'variable' => $model->variable], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'variable' => $model->variable], [
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
            'variable',
            'nama',
            'divisi',
            'val',
            'detail:ntext',
            'status',
        ],
    ]) ?>

</div>

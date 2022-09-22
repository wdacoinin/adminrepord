<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AktivaT */

$this->title = $model->aktiva;
$this->params['breadcrumbs'][] = ['label' => 'Aktiva Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="aktiva-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'aktiva' => $model->aktiva], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'aktiva' => $model->aktiva], [
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
            'aktiva',
            'aktiva_nama',
            'd_k',
            'status',
        ],
    ]) ?>

</div>

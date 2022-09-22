<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DopT */

$this->title = $model->do;
$this->params['breadcrumbs'][] = ['label' => 'Dop Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="dop-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'do' => $model->do], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'do' => $model->do], [
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
            'do',
            'do_tgl',
            'supplier',
            'do_status',
            'us',
            'faktur',
            'do_tempo',
            'no_sj',
            'keterangan:ntext',
            'do_diskon',
            'ppn',
        ],
    ]) ?>

</div>

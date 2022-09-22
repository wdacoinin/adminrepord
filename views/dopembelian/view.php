<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Dopembelianv */

$this->title = $model->do;
$this->params['breadcrumbs'][] = ['label' => 'Dopembelianvs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="dopembelianv-view">

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
            'supplier_nama',
            'faktur',
            'do_tempo',
            'no_sj',
            'nama',
            'do_diskon',
            'total',
            'ppn',
            'total_plus_ppn',
        ],
    ]) ?>

</div>

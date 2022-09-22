<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MerekT */

$this->title = $model->merek;
$this->params['breadcrumbs'][] = ['label' => 'Merek Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="merek-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'merek' => $model->merek], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'merek' => $model->merek], [
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
            'merek',
            'nama',
        ],
    ]) ?>

</div>

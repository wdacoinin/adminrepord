<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BebanT */

$this->title = $model->beban;
$this->params['breadcrumbs'][] = ['label' => 'Beban Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="beban-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'beban' => $model->beban], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'beban' => $model->beban], [
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
            'beban',
            'nama',
        ],
    ]) ?>

</div>

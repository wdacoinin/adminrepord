<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AkunT */

$this->title = $model->akun;
$this->params['breadcrumbs'][] = ['label' => 'Akun Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akun-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'akun' => $model->akun], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'akun' => $model->akun], [
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
            'akun',
            'akun_nama',
            'an',
            'akun_ref',
            'akun_owner',
            'akun_type',
        ],
    ]) ?>

</div>

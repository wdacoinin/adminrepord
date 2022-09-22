<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AkunSaldoT */

$this->title = $model->akun_saldo;
$this->params['breadcrumbs'][] = ['label' => 'Akun Saldo Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akun-saldo-t-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'akun_saldo' => $model->akun_saldo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'akun_saldo' => $model->akun_saldo], [
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
            'akun_saldo',
            'aktiva',
            'akun',
            'noref',
            'ket:ntext',
            'jml',
            'datetime',
            'user',
            'nama_foto',
            'type',
            'size',
            'url:url',
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StokJenisT */

$this->title = 'Update Stok Jenis: ' . $model->stok_jenis_nama;
$this->params['breadcrumbs'][] = ['label' => 'Stok Jenis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->stok_jenis_nama, 'url' => ['view', 'stok_jenis' => $model->stok_jenis]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="list-group-item">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
<div class="container-flex">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

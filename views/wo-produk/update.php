<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WoProdukT */

$this->title = 'Update Wo Produk T: ' . $model->wo_produk;
$this->params['breadcrumbs'][] = ['label' => 'Wo Produk Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->wo_produk, 'url' => ['view', 'wo_produk' => $model->wo_produk]];
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

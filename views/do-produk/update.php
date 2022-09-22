<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DoProdukT */

$this->title = 'Update Do Produk T: ' . $model->do_produk;
$this->params['breadcrumbs'][] = ['label' => 'Do Produk Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->do_produk, 'url' => ['view', 'do_produk' => $model->do_produk]];
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

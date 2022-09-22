<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DoProdukT */

$this->title = 'Update Do Produk: ' . $model->produk0->nama;
$this->params['breadcrumbs'][] = ['label' => 'Do Produk', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->produk0->nama, 'url' => ['view', 'do_produk' => $model->do_produk]];
?>
<div class="list-group-item">
    <h1><?= Html::encode($this->title) ?></h1>

</div>
<div class="container-flex">
    <?= $this->render('_formprodukupdate', [
        'model' => $model,
        'UpForm' => $UpForm,
    ]) ?>
</div>

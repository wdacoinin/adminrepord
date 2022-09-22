<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PengirimanT */

$this->title = 'Update Pengiriman T: ' . $model->pengiriman;
$this->params['breadcrumbs'][] = ['label' => 'Pengiriman Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pengiriman, 'url' => ['view', 'pengiriman' => $model->pengiriman]];
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

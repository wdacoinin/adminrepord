<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RmaItemT */

$this->title = 'Update Rma Item T: ' . $model->rma_item;
$this->params['breadcrumbs'][] = ['label' => 'Rma Item Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rma_item, 'url' => ['view', 'rma_item' => $model->rma_item]];
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

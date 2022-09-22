<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InventoriT */

$this->title = 'Update Inventori: ' . $model->kode;
$this->params['breadcrumbs'][] = ['label' => 'Inventori', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kode, 'url' => ['view', 'inventori' => $model->inventori]];
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

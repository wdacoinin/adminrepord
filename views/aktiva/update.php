<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AktivaT */

$this->title = 'Update Aktiva: ' . $model->aktiva_nama;
$this->params['breadcrumbs'][] = ['label' => 'Aktiva', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->aktiva_nama, 'url' => ['view', 'aktiva' => $model->aktiva]];
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

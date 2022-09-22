<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReportT */

$this->title = 'Update Report: ' . $model->report;
$this->params['breadcrumbs'][] = ['label' => 'Report Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->report, 'url' => ['view', 'report' => $model->report]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-md-12">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
<div class="container-flex">
    <?= $this->render('_formupdate', [
        'model' => $model,
    ]) ?>
</div>

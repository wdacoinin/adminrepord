<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RmaT */

$this->title = 'Update RMA: ' . $model->rma;
$this->params['breadcrumbs'][] = ['label' => 'RMA', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rma, 'url' => ['view', 'rma' => $model->rma]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="list-group-item">
    <h1><?= Html::encode($this->title) ?></h1>

</div>
<div class="container-flex">
    <?= $this->render('_formupdate', [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>
</div>

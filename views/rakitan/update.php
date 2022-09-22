<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RakitanT */

$this->title = 'Update Rakitan: ' . $model->inventori0->kode . '-' . $model->rakitan;
$this->params['breadcrumbs'][] = ['label' => 'Rakitan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->inventori0->kode . '-' . $model->rakitan , 'url' => ['view', 'rakitan' => $model->rakitan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="list-group-item">
    <h1><?= Html::encode($this->title) ?></h1>

</div>
<div class="row m-auto">
    <?= $this->render('_formupdate', [
        'model' => $model,
    ]) ?>
</div>

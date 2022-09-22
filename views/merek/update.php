<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MerekT */

$this->title = 'Update Merek: ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Merek', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama, 'url' => ['view', 'merek' => $model->merek]];
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

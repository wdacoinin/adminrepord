<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VariableT */

$this->title = 'Update : ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'MJ Teknologi Semarang Setting', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama, 'url' => ['view', 'variable' => $model->variable]];
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

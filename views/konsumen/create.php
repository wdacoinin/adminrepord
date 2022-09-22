<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\KonsumenT */

$this->title = 'Create Konsumen T';
$this->params['breadcrumbs'][] = ['label' => 'Konsumen Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list-group-item">
    <h1><?= Html::encode($this->title) ?></h1>

</div>
<div class="container-flex">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

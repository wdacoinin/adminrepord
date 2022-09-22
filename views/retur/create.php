<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReturT */

$this->title = 'Create Retur T';
$this->params['breadcrumbs'][] = ['label' => 'Retur Ts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list-group-item">
    <h1><?= Html::encode($this->title) ?></h1>

</div>
<div class="container-flex">
    <?= $this->render('_form', [
        'model' => $model,
        'action' => 0,
        'UpForm' => $UpForm,
    ]) ?>
</div>

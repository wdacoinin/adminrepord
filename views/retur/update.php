<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReturT */

$this->title = 'Update Retur: ' . $model->noretur;
//$this->params['breadcrumbs'][] = ['label' => 'Retur Ts', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->retur, 'url' => ['view', 'retur' => $model->retur]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="list-group-item">
    <h1><?= Html::encode($this->title) ?></h1>

</div>
<div class="container-flex">
    <?= $this->render('_formupdate', [
        'model' => $model,
        'searchModel' => $searchModel, 
        'dataProvider' => $dataProvider
    ]) ?>
</div>

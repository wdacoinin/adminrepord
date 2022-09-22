<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DopT */

$this->title = 'Update DO Pembelian: ' . $model->faktur;
$this->params['breadcrumbs'][] = ['label' => 'DO Pembelian', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->faktur, 'url' => ['view', 'do' => $model->do]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="list-group-item">
    <h1><?= Html::encode($this->title) ?></h1>

</div>
<div class="row pr-4 pl-4">
    <?= $this->render('_formupdate', [
        'model' => $model,
        'searchModel2' => $searchModel2,
        'dataProvider2' => $dataProvider2,
    ]) ?>
</div>

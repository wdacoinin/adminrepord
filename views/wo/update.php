<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WoT */

$this->title = 'Update Working Order: ' . $model->wo;
//$this->params['breadcrumbs'][] = ['label' => 'Wo', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->wo, 'url' => ['view', 'wo' => $model->wo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="list-group-item">
    <h1><?= Html::encode($this->title) ?></h1>

</div>
<div class="container-flex">
    <?= $this->render('_formupdate', [
        'model' => $model,
    ]) ?>
</div>

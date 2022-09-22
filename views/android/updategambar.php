<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RakitanT */

$this->title = 'Update Pengiriman: ' . $model->surat_jalan;
//$this->params['breadcrumbs'][] = ['label' => 'Rakitan', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->inventori0->kode . '-' . $model->rakitan, 'url' => ['view', 'rakitan' => $model->rakitan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="list-group-item">
    <h1><?= Html::encode($this->title) ?></h1>

</div>
<div class="container-flex">
    <?= $this->render('_formgambar', [
        'model' => $model,
        'action' => $action,
        'UpForm' => $UpForm,
    ]) ?>
</div>

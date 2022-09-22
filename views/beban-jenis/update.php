<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BebanJenisT */

$this->title = 'Update Jenis Beban: ' . $model->beban_jenis_nama;
$this->params['breadcrumbs'][] = ['label' => 'Beban Jenis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->beban_jenis_nama, 'url' => ['view', 'beban_jenis' => $model->beban_jenis]];
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

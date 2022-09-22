<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AkunT */

$this->title = 'Update Akun: ' . $model->akun_nama . ' ' . $model->akun_ref;
$this->params['breadcrumbs'][] = ['label' => 'Akun Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->akun_nama . ' ' . $model->akun_ref, 'url' => ['view', 'akun' => $model->akun]];
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

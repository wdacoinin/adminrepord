<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dopembelianv */

$this->title = 'Create Dopembelian';
$this->params['breadcrumbs'][] = ['label' => 'Dopembelianvs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list-group-item">
    <h1><?= Html::encode($this->title) ?></h1>

</div>
<div class="container-flex">
    <?= $this->render('_formproduk', [
        'model' => $model,
        'UpForm' => $UpForm,
    ]) ?>
</div>

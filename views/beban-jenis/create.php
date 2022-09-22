<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BebanJenisT */

$this->title = 'Create Jenis Beban';
$this->params['breadcrumbs'][] = ['label' => 'Jenis Beban', 'url' => ['index']];
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

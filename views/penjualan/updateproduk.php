<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dopembelianv */

$this->title = 'Update';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list-group-item">
    <h1><?= Html::encode($this->title) ?></h1>

</div>
<div class="container-flex">
    <?= $this->render('_formprodukupdate', [
        'model' => $model,
        'sebatch' => $sebatch,
        'modProdukOrigin' => $modProdukOrigin
    ]) ?>
</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RakitanT */

$this->title = 'Input Produk Rakitan';
?>
<div class="list-group-item">
    <h1><?= Html::encode($this->title) ?></h1>

</div>
<div class="container-flex">
    <?= $this->render('_forminputrakitan', [
        'model' => $model,
    ]) ?>
</div>

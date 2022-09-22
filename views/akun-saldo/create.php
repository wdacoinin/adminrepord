<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AkunSaldoT */

$this->title = 'Create Transaksi Uang Keluar / Masuk';
$this->params['breadcrumbs'][] = ['label' => 'Transaksi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list-group-item">
    <h1><?= Html::encode($this->title) ?></h1>

</div>
<div class="col-md-12">
<div class="row">
    <?= $this->render('_form', [
        'model' => $model,
        'from' => $from,
        'action' => 0,
        'UpForm' => $UpForm,
    ]) ?>
</div>
</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AkunSaldoT */

$this->title = 'Update Transaksi: ' . $model->notrans;
//$this->params['breadcrumbs'][] = ['label' => 'Akun Transaksi', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->notrans, 'url' => ['view', 'akun_saldo' => $model->akun_saldo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="list-group-item">
    <h1><?= Html::encode($this->title) ?></h1>

</div>
<div class="col-md-12">
<div class="row">
    <?= $this->render('_formupdate', [
        'model' => $model,
        'action' => 1,
        'UpForm' => $UpForm,
    ]) ?>
</div>
</div>

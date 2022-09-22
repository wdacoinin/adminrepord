<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dopembelianv */

$this->title = 'Update Do Pembelian: ' . $model->faktur;
$this->params['breadcrumbs'][] = ['label' => 'DO Pembelian', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->faktur];
?>
<div class="row p-3">
    <?= $this->render('_form', [
        'model' => $model,
        'modTotal' => $modTotal,
        'DoProduk' => $DoProduk,
        'DocPemb' => $DocPemb,
        'searchModel2' => $searchModel2,
        'dataProvider2' => $dataProvider2,
        'searchModel3' => $searchModel3,
        'dataProvider3' => $dataProvider3,
    ]) ?>
</div>

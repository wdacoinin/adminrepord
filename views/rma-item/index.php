<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RmaItem */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rma Item Ts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rma-item-t-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Rma Item T', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'rma_item',
            'rma',
            'produk',
            'rma_jml',
            'rma_harga',
            //'rma_ket:ntext',
            //'nama_foto',
            //'type',
            //'size',
            //'url:url',
            //'id_user',
            //'timestamp',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, RmaItemT $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'rma_item' => $model->rma_item]);
                 }
            ],
        ],
    ]); ?>


</div>

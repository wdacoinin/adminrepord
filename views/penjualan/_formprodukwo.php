<?php

use app\models\InventoriT;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\ProdukT;
use app\models\KategoriT;
use app\models\StokJenisT;
use app\models\MerekT;
use app\models\RakitanT;
use app\models\WoT;
use kartik\number\NumberControl;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\DoProdukT */
/* @var $form yii\widgets\ActiveForm */
/* $action = Url::to(['/do-produk/create']);
$actionback = Url::to(['/dop/update', 'do' => $model->do]); */
$today = date('Y-m-d');
?>


<?php $form = ActiveForm::begin([
    'id' => 'create-produkwo', 
    'enableAjaxValidation' => false
    ]); ?>
<div class="col-md-12">


    <?= // Usage with ActiveForm and model
    $form->field($model, 'wo')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(WoT::find()->select(["wo, CONCAT('WO-', wo) AS wod"])
        ->where(['id_user' => Yii::$app->user->identity->id])
        ->asArray()->all(), 'wo', 'wod'),
        'options' => ['placeholder' => 'Pilih'],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => '#modal3'
        ],
    ]);
    ?>

</div>
<div class="list-group-item">
        <?= Html::submitButton('Input WO', ['id' => 'woproduk', 'class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
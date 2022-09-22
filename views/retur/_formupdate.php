<?php

use app\models\AkunSaldoPj;
use app\models\AkunSaldoT;
use app\models\AkunT;
use app\models\BackendUser;
use app\models\DopT;
use app\models\KonsumenT;
use app\models\User;
use kartik\date\DatePicker;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\MyFormatter;
use app\models\PenjualanProdukTtT;
use app\models\Penjualanv;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanT */
/* @var $form yii\widgets\ActiveForm */
$dispOptions = ['class' => 'form-control'];
$saveOptions = [
    'type' => 'hidden', 
    'label'=>'', 
    'class' => 'form-control',
    'readonly' => true, 
    'tabindex' => 1000
];
$saveCont = ['class' => 'kv-saved-cont'];
$today = date('Y-m-d');
$tempo = date('Y-m-d', strtotime(' +3 day'));
?>

<div class="penjualan-t-form">

    <div class="col-md-12">
    <div class="row">

        <div class="col-md-4">
            <div class="card-header text-white bg-secondary">Data Tambahan</div>
            <div class="card-body bg-light">
                <div class="row bg-light p-0">
                    
                    <?php $form = ActiveForm::begin([
                        'id' => 'update-rakitan', 
                        'enableAjaxValidation' => true
                    ]); ?>

                        <div class="col-md-12">

                            <?= // Usage with ActiveForm and model
                            $form->field($model, 'do')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(DopT::find()
                                ->select(["do.do, CONCAT(do.faktur, ' - ', supplier.supplier_nama) AS faktur"])
                                ->join("LEFT JOIN", "supplier", "do.supplier=supplier.supplier")
                                ->orderBy('do.faktur')->asArray()->all(), 'do', 'faktur'),
                                'options' => ['placeholder' => 'Pilih', 'value' => $model->do],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    //'dropdownParent' => '#modal'
                                ],
                            ]); 
                            ?>

                            <?=
                            $form->field($model, 'date')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'Tgl.Retur', 'value' => $today],
                                'pluginOptions' => [
                                    'todayHighlight' => true,
                                    'calendarWeeks' => true,
                                    //'daysOfWeekDisabled' => [0, 6],
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                            ?>

                            <?= $form->field($model, 'noretur')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                            <?= // Usage with ActiveForm and model
                            $form->field($model, 'retur_status')->widget(Select2::classname(), [
                                'data' => [1 => 'Proses', 2 => 'Selesai Replace barang beda', 3 => 'Selesai diganti uang', 4 => 'Selesai replace barang identik'],
                                'options' => ['placeholder' => 'Pilih', 'value' => $model->retur_status],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    //'dropdownParent' => '#modal'
                                ],
                            ]); 
                            ?>

                            <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>
                        
                        </div>
                        <div class="form-group">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

        <div class="col-md-8">

            <?= $this->render('../retur/_tableproduk', [
                'model' => $model,
                'do' => $model->do,
                'searchModel' => $searchModel, 
                'dataProvider' => $dataProvider
            ]) ?>
           
        </div>
            
        </div>

</div>

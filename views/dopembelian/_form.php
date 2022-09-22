<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\SupplierT;
use app\models\VariableT;
use app\models\DoProduk;
use app\models\MyFormatter;
use kartik\number\NumberControl;
use yii\bootstrap5\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\DopT */
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
$tempo = date('Y-m-d', strtotime(' +25 day'));

$ppnv = VariableT::find()->select('val')->where('variable = 4')->one();
$ppn = $ppnv['val'];
?>


    <div class="col-md-4">
    <?php $form = ActiveForm::begin(['id' => 'update', 'enableAjaxValidation' => true]); ?>
    <!---DATA DO--->
    <div class="card col-md-12 p-0">
        <div class="card-header text-white bg-secondary">Data Tambahan</div>
        <div class="card-body bg-light">
        <div class="row bg-light p-0">
            <div class="col-md-12">

                <?= $form->field($model, 'faktur')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                <?= $form->field($model, 'no_sj')->textInput(['maxlength' => true]) ?>

                <?= // Usage with ActiveForm and model
                $form->field($model, 'supplier')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(SupplierT::find()->orderBy('supplier_nama ASC')->asArray()->all(), 'supplier', 'supplier_nama'),
                    'options' => ['placeholder' => 'Pilih'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        //'dropdownParent' => '#modal'
                    ],
                ]);
                ?>

                <?php
                // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
                // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
                // is disallowed.
                echo $form->field($model, 'do_diskon')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'prefix' => 'Rp. ',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false
                    ],
                    'options' => $saveOptions,
                    'displayOptions' => $dispOptions,
                    'saveInputContainer' => $saveCont
                ]);
                ?>

                <?= // Usage with ActiveForm and model
                $form->field($model, 'ppn')->widget(Select2::classname(), [
                    'data' => [$ppn => 'Exclude', 0 => 'Include Ppn'],
                    'options' => ['placeholder' => 'Pilih'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        //'dropdownParent' => '#modal'
                    ],
                ]);
                ?>

                <?= $form->field($model, 'us')->textInput(['readonly' => true, 'value' => $model->us]) ?>

            </div>

            <div class="col-md-12">

                <?=
                $form->field($model, 'do_tgl')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Tgl.Pembelian', 'value' => $model->do_tgl],
                    'pluginOptions' => [
                        'todayHighlight' => true,
                        'calendarWeeks' => true,
                        //'daysOfWeekDisabled' => [0, 6],
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
                ?>

                <?=
                $form->field($model, 'do_tempo')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Tgl.Tempo', 'value' => $model->do_tempo],
                    'pluginOptions' => [
                        'todayHighlight' => true,
                        'calendarWeeks' => true,
                        //'daysOfWeekDisabled' => [0, 6],
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
                ?>

                <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

                <?php if($modTotal->total_plus_ppn > $modTotal->total_bayar){ ?>
                    <?= $form->field($model, 'do_status')->textInput(['readonly' => true, 'value' => 'Hutang']) ?>
                <?php }else{ ?> 
                    <?php if(Yii::$app->user->identity->divisi == 1){ ?>

                        <?= // Usage with ActiveForm and model
                        $form->field($model, 'do_status')->widget(Select2::classname(), [
                            'data' => ['Hutang' => 'Hutang', 'Lunas' => 'Lunas'],
                            'options' => ['placeholder' => 'Pilih'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                //'dropdownParent' => '#modal'
                            ],
                        ]);
                        ?>

                    <?php }else{ ?> 
                        <?= $form->field($model, 'do_status')->textInput(['readonly' => true, 'value' => 'Lunas']) ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        </div>
    </div>
    
    <div class="list-group-item">
            <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>

    <div id="list-produk" class="col-md-8"> 

        <?= $this->render('../dopembelian/_tableproduk', [
            'model' => $model,
            'do' => $model->do,
            'searchModel' => $searchModel2, 
            'dataProvider' => $dataProvider2
        ]) ?>

        <div class="card col-md-12 p-0 mt-0 mb-0">
            <div class="card-header text-white bg-primary">Total</div>
            <div class="card-body bg-light">
                <div class="row bg-light p-0">
                    <table class="table table-sm table-hover">
                    <thead class="table-light">
                        <tr>
                        <th width="70%" class="text-right">#</th>
                        <th width="30%" class="text-center">Val</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-right">Total</td>
                            <td class="text-right">
                                <?php 
                                if($modTotal->total > 0){
                                    echo MyFormatter::formatUang($modTotal->total + $modTotal->do_diskon);
                                }else{
                                    echo 0;
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <td class="text-right">Diskon</td>
                            <td class="text-right"><?php
                            if($modTotal->do_diskon > 0){
                                echo MyFormatter::formatUang($modTotal->do_diskon);
                            }else{
                                echo 0;
                            }
                            ?></td>
                        </tr>
                        <tr>
                            <td class="text-right">Ppn</td>
                            <td class="text-right"><?php 
                            if($modTotal->ppn > 0){
                                echo MyFormatter::formatUang($modTotal->ppn);
                            }else{
                                echo 0;
                            }?></td>
                        </tr>
                        <tr>
                            <td class="text-right">Total+Ppn</td>
                            <td class="text-right"><?php 
                            if($modTotal->total_plus_ppn > 0){
                                echo MyFormatter::formatUang($modTotal->total_plus_ppn);
                            }else{
                                echo 0;
                            }?></td>
                        </tr>
                        <tr>
                            <td class="text-right fw-bold">Grand Total</td>
                            <td class="text-right fw-bold"><?php 
                            if($modTotal->total_plus_ppn > 0){
                                echo MyFormatter::formatUang($modTotal->total_plus_ppn);
                            }else{
                                echo 0;
                            }
                            ?></td>
                        </tr>
                        <tr>
                            <td class="text-right fw-bold">Total Terbayar</td>
                            <td class="text-right fw-bold"><?php 
                            if($modTotal->total_bayar > 0){
                                echo MyFormatter::formatUang($modTotal->total_bayar);
                            }else{
                                echo 0;
                            }?></td>
                        </tr>
                        <tr>
                            <td class="text-right fw-bold">Hutang</td>
                            <td class="text-right fw-bold">
                                <?php 
                                if($modTotal->total_plus_ppn > 0){
                                    if($modTotal->total_plus_ppn > $modTotal->total_bayar){ $ht = $modTotal->total_plus_ppn - $modTotal->total_bayar;}else{ $ht = 0;}
                                    echo MyFormatter::formatUang($ht);
                                }else{
                                    echo 0;
                                }?>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?= $this->render('../akun-saldo/index', [
            'model' => $model,
            'do' => $model->do,
            'searchModel' => $searchModel3, 
            'dataProvider' => $dataProvider3
        ]) ?>

        <!---- FORM FILE ----->
        <div class="container-flex d-print-none">
            <div class="card">
                <div class="card-header p-2 d-flex bg-info">
                    <div class="mr-auto">
                        <div class="d-flex">
                        <i class="mr-2 text-white align-self-center" data-feather="book-open"></i> 
                        <span class="align-self-center mr-2">
                            <h5 class="card-title mb-0 text-white">File Pembelian</b>
                            </h5>
                        </span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3" id="collapseFile" class="collapse show">
            
                    <a class="btn btn-primary modalButton" value="<?= Url::to(['upload', 'do' => $_GET['do']]) ?>"><i class="fas fa-upload"></i> Upload File</a>
                            
                    <div class="row">  

                    
                    <!---DISPLAY FILE--->
                    <?= $this->render('_displayFile', [
                        'model' => $model, 
                        'DoProduk' => $DoProduk,
                        'DocPemb' => $DocPemb,
                    ]) ?>


                    </div>
                </div>
            </div>
        </div>
        <!---- END FORM pembelian ----->
    </div>
    
<script async='async' type='text/javascript'>
    $('.modal-dialog').draggable();
</script>

<style>
    .form-group {
        margin-bottom: 4px !important;
    }
    .kv-page-summary-container{
        min-height: 135vh !important;
    }
    .control-label {
        margin-bottom: 2px !important;
    }

    .hide {
        display: none;
    }

    .modal {
        overflow-y: auto;
    }
    #modal3 .modal-header{
        background-color: #666;
    }
    .modal-xl {
    max-width: 90% !important;
    }
    .card{
        margin-bottom: 3px !important;
    }
</style>
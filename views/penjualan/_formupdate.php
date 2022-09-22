<?php

use app\models\AkunSaldoPj;
use app\models\AkunSaldoT;
use app\models\AkunT;
use app\models\BackendUser;
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
                            <?=
                            $form->field($model, 'penjualan_tgl')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'Tgl.Penjualan', 'value' => $today],
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
                            $form->field($model, 'penjualan_tempo')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'Tgl.Tempo', 'value' => $tempo],
                                'pluginOptions' => [
                                    'todayHighlight' => true,
                                    'calendarWeeks' => true,
                                    //'daysOfWeekDisabled' => [0, 6],
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                            ?>

                            <?= // Usage with ActiveForm and model
                            $form->field($model, 'konsumen')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(KonsumenT::find()->select(["konsumen, CONCAT(konsumen_nama, ' Telp:', konsumen_telp) AS konsumen_nama"])->orderBy('konsumen_nama ASC')->asArray()->all(), 'konsumen', 'konsumen_nama'),
                                'options' => ['placeholder' => 'Pilih'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    //'dropdownParent' => '#modal'
                                ],
                            ]);
                            ?>

                            <?= $form->field($model, 'faktur')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                            <?= $form->field($model, 'surat_jalan')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>
                        
                            <?php
                            // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
                            // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
                            // is disallowed.
                            echo $form->field($model, 'penjualan_ongkir')->widget(NumberControl::classname(), [
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
                        
                            <?php
                            // Number mask widget with ActiveForm and model validation rule (amounts between 1 to 100000). 
                            // Initial value is set to 1400.50. Note the prefix and suffix settings and how the minus sign
                            // is disallowed.
                            echo $form->field($model, 'fee')->widget(NumberControl::classname(), [
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

                            <?=
                            $form->field($model, 'fee_date')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'Tgl.Fee', 'value' => $today],
                                'pluginOptions' => [
                                    'todayHighlight' => true,
                                    'calendarWeeks' => true,
                                    //'daysOfWeekDisabled' => [0, 6],
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                            ?>
                                
                            <?= // Usage with ActiveForm and model
                            $form->field($model, 'sales')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(BackendUser::find()->where('divisi >= 2')->orderBy('nama ASC')->asArray()->all(), 'id', 'nama'),
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
                            echo $form->field($model, 'penjualan_diskon')->widget(NumberControl::classname(), [
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

                            <?= $form->field($model, 'user')->textInput(['hidden' => true, 'value' => Yii::$app->user->identity->id])->label(false) ?>

                            <?php
                                $cpembayaran = Penjualanv::findOne($model->penjualan);
                                if( $cpembayaran->total_plus_ppn > 0 ){ $max = $cpembayaran->total_plus_ppn; } else { $max = 0; }
                                //get total bayar jika ada
                                if( $cpembayaran->total_bayar > 0 ){ $total_bayar =$cpembayaran->total_bayar; } else { $total_bayar = 0; }
                                //kekurangan
                                $kkurang = $max - $total_bayar;
                                //get tt
                                $modPenjTT = PenjualanProdukTtT::find()->select('SUM(do_jml*do_hpp) AS totaltt')->where(['penjualan' => $model->penjualan])->asArray()->one();
                                if($modPenjTT != null){
                                    $totaltt = (int) $modPenjTT['totaltt'];
                                    $kurang = $kkurang - $totaltt;
                                }else{
                                    $kurang = $kkurang;
                                }
                                
                            ?>
                            
                            <?php if($kurang > 0){ ?>
                                <?= $form->field($model, 'penjualan_status')->textInput(['readonly' => true, 'value' => 'Piutang']) ?>
                            <?php }else{ ?>
                                
                                <?php if(Yii::$app->user->identity->divisi == 1){ ?>

                                    <?= // Usage with ActiveForm and model
                                    $form->field($model, 'penjualan_status')->widget(Select2::classname(), [
                                        'data' => ['Piutang' => 'Piutang', 'Lunas' => 'Lunas'],
                                        'options' => ['placeholder' => 'Pilih'],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            //'dropdownParent' => '#modal'
                                        ],
                                    ]);
                                    ?>

                                <?php }else{ ?> 
                                    <?= $form->field($model, 'penjualan_status')->textInput(['readonly' => true, 'value' => 'Lunas']) ?>
                                <?php } ?>
                            <?php } ?>

                            <?= // Usage with ActiveForm and model
                            $form->field($model, 'akun')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(AkunT::find()->select(["akun, CONCAT(akun_nama, ' rek:', akun_ref) AS akun_nama"])->orderBy('akun_nama ASC')->asArray()->all(), 'akun', 'akun_nama'),
                                'options' => ['placeholder' => 'Pilih'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    //'dropdownParent' => '#modal'
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

        <div class="col-md-8">

            <?= $this->render('../penjualan/_tableproduk', [
                'model' => $model,
                'penjualan' => $model->penjualan,
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
                                        //harus ditambah diskon karena cari nilai asli transaksi
                                        echo MyFormatter::formatUang($modTotal->total + $modTotal->penjualan_diskon);
                                    }else{
                                        echo 0;
                                    }
                                    ?></td>
                            </tr>
                            <tr>
                                <td class="text-right">Potongan TT</td>
                                <td class="text-right"><?php
                                $modPenjTT = PenjualanProdukTtT::find()->select('SUM(do_jml*do_hpp) AS totaltt')->where(['penjualan' => $model->penjualan])->asArray()->one();
                                if($modPenjTT != null){
                                    $totaltt = (int) $modPenjTT['totaltt'];
                                    echo MyFormatter::formatUang($totaltt);
                                }else{
                                    $totaltt = 0;
                                    echo 0;
                                }
                                ?></td>
                            </tr>
                            <tr>
                                <td class="text-right">Diskon</td>
                                <td class="text-right"><?php
                                if($modTotal->penjualan_diskon > 0){
                                    echo MyFormatter::formatUang($modTotal->penjualan_diskon);
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
                                    $gt = $modTotal->total_plus_ppn - $totaltt;
                                    echo MyFormatter::formatUang($gt);
                                }else{
                                    $gt = 0;
                                    echo 0;
                                }
                                ?></td>
                            </tr>
                            <tr>
                                <td class="text-right fw-bold">Total Terbayar</td>
                                <td class="text-right fw-bold"><?php 
                                if($modTotal->total_bayar > 0){
                                    $totalbayar = $modTotal->total_bayar;
                                    echo MyFormatter::formatUang($totalbayar);
                                }else{
                                    $totalbayar = 0;
                                    echo 0;
                                }?></td>
                            </tr>
                            <tr>
                                <td class="text-right fw-bold">Piutang</td>
                                <td class="text-right fw-bold">
                                    <?php 
                                    if($modTotal->total_plus_ppn > 0){
                                        if($modTotal->total_plus_ppn > $modTotal->total_bayar){ $ht = $modTotal->total_plus_ppn - $modTotal->total_bayar;}else{ $ht = 0;}
                                        if($totaltt > 0){
                                            $ht = $ht - $totaltt;
                                        }
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
                'penjualan' => $model->penjualan,
                'searchModel' => $searchModel3, 
                'dataProvider' => $dataProvider3
            ]) ?>

            <?= $this->render('../penjualan/_tablettproduk', [
                'penjualan' => $model->penjualan,
                'searchModel' => $searchModel4, 
                'dataProvider' => $dataProvider4
            ]) ?>

            <!---- FORM FILE ----->
            <div class="container-flex d-print-none">
                <div class="card">
                    <div class="card-header p-2 d-flex bg-info">
                        <div class="mr-auto">
                            <div class="d-flex">
                            <i class="mr-2 text-white align-self-center" data-feather="book-open"></i> 
                            <span class="align-self-center mr-2">
                                <h5 class="card-title mb-0 text-white">File Penjualan</b>
                                </h5>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3" id="collapseFile" class="collapse show">
                
                        <a class="btn btn-primary modalButton" value="<?= Url::to(['upload', 'penjualan' => $_GET['penjualan']]) ?>"><i class="fas fa-upload"></i> Upload File</a>
                    
                        <?php if($DocKonsumen > 0 && $DocBarang > 0 && $DocTransaksi){ ?>
                        <a href="./index.php?r=penjualan/print&penjualan=<?php echo $model->penjualan; ?>" target="_blank" class="btn btn btn-success ml-2"><i class="align-middle" data-feather="printer"></i> Print Nota</a>
                        <?php } ?>
                        <div class="row">  

                        
                        <!---DISPLAY FILE--->
                        <?= $this->render('_displayFile', [
                            'model' => $model, 
                            'DocPenj' => $DocPenj,
                        ]) ?>


                        </div>
                    </div>
                </div>
            </div>
           
        </div>
            
        </div>

</div>

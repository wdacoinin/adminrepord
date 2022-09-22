<?php

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
use yii\helpers\Url;
use yii\bootstrap5\Modal;

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
?>

<div class="rma-t-form">

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
                            $form->field($model, 'rma_status')->widget(Select2::classname(), [
                                'data' => ['Proses' => 'Proses', 'Selesai' => 'Selesai'],
                                'options' => ['placeholder' => 'Pilih', 'value' => $model->rma_status],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); 
                            ?>

                            <?= // Usage with ActiveForm and model
                            $form->field($model, 'konsumen')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(KonsumenT::find()->select(["konsumen, CONCAT(konsumen_nama, ' Telp:', konsumen_telp) AS konsumen_nama"])->orderBy('konsumen_nama ASC')->asArray()->all(), 'konsumen', 'konsumen_nama'),
                                'options' => ['placeholder' => 'Pilih', 'value' => $model->konsumen],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); 
                            ?>

                            <?=
                            $form->field($model, 'rma_date')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'Tgl.Penjualan', 'value' => $model->rma_date],
                                'pluginOptions' => [
                                    'todayHighlight' => true,
                                    'calendarWeeks' => true,
                                    //'daysOfWeekDisabled' => [0, 6],
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
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

            <?= $this->render('../rma/_tableproduk', [
                'rma' => $model->rma,
                'searchModel' => $searchModel, 
                'dataProvider' => $dataProvider
            ]) ?>
           
        </div>

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
            
                    <a class="btn btn-primary modalButton" value="<?= Url::to(['upload', 'rma' => $_GET['rma']]) ?>"><i class="fas fa-upload"></i> Upload Nota Distri RMA</a>
                
                    <div class="row">  

                    
                    <!---DISPLAY FILE--->
                    <?= $this->render('_displayFile', [
                        'model' => $model
                    ]) ?>


                    </div>
                </div>
            </div>
        </div>
            
        </div>

</div>


<!----MODAL---------------->
<?php
    $js=<<<js
        $('.modalButton').click( function () {
            $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
        });
    js;
    $this->registerJs($js);
    Modal::begin([
        'title' => '<h2><i class="align-middle" data-feather="alert-circle"></i> </h2>',
        'id' => 'modal',
        'size' => 'modal-md',
    ]);
    echo "<div id='modalContent' class='p-0'></div>";
    Modal::end();
?>
<!----END MODAL-------------->


<style>	
	.hide {
		display: none;
	}
    .modal-body{
        padding: 0px !important;
    }
    .dropdown-menu.show{
        text-align: center !important;
    }
</style>
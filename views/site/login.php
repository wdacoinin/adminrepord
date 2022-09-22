<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Login';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offset-md-4 col-md-4 col-sm-10 offset-sm-1">
<div class="d-flex justify-content-center align-items-center" style="position:absolute !important;min-height:100vh;visibility:visible;z-index:999;">

    <!-- <p>Please fill out the following fields to login:</p> -->

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-12 col-form-label'],
        ],
    ]); ?>
        <div class="d-flex justify-content-center align-items-center">
        <img src="../assets/images/LOGO.png" width="55" class="img-responsive"/>
        </div>
        <h3 class="text-center"><?= Html::encode($this->title) ?></h3>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-12 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-12\">{error}</div>",
        ]) ?>
        <div class="form-group">
            <div class="col-lg-12">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

    <!-- <div class="offset-lg-1" style="color:#999;">
        You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
        To modify the username/password, please check out the code <code>app\models\User::$users</code>.
    </div> -->
    </div>
</div>

<!-- particles.js container -->
<div id="particles-js"></div>

<!-- scripts -->
<script src="../assets/js/particles.js"></script>
<script src="../assets/js/apppart.js"></script>
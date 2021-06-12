<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-box">
  <div class="login-logo">
    <a href=""><b>Bridge Campus</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <?php $form = ActiveForm::begin([
      'layout' => 'horizontal',
      'fieldConfig' => [
        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
          'label' => 'col-sm-4',
          'offset' => '',
          'wrapper' => '',
          'error' => '',
          'hint' => '',
        ],
      ],
    ]); ?>
    <div class="form-group has-feedback">
      <?= $form->field($model, 'email',['template' => '<div><span class="glyphicon glyphicon-envelope form-control-feedback"></span>{input}{error}</div>'])->textInput(['autofocus' => true,"placeholder"=>"Email"]) ?>
    </div>
    <div class="form-group has-feedback">
      <?= $form->field($model, 'password',['template' => '<div><span class="glyphicon glyphicon-lock form-control-feedback"></span>{input}{error}</div>'])->passwordInput([
        "placeholder"=>"Password"]) ?>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
        </div>
        <!-- /.col -->
      </div>
      <?php ActiveForm::end(); ?>

      <a href="#">I forgot my password</a><br>
      <a href="register.html" class="text-center">Register a new membership</a>

    </div>
    <!-- /.login-box-body -->
    <p class="text-center copyright">
      <strong>Copyright &copy; <?= date('Y') ?> <a href="<?= Url::home() ?>">Bridge Campus</a>.</strong> All rights
      reserved.
    </p>
  </div>

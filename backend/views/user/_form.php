
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\widgets\SwitchInput;
use yii\helpers\ArrayHelper;
use app\models\User;
use kartik\widgets\FileInput;
use app\components\CustomUrlRule;
use backend\controllers\UserController;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $model common\models\Specialization */
/* @var $form yii\widgets\ActiveForm */
$validateUrl = ($model->isNewRecord)?Url::to(['user/validate']):Url::to(['user/validate','id'=>$model->id]);
?>

<div class="user-form">
  <div class="custumbox box box-info">
   <div class="box-body">

    <?php $form = ActiveForm::begin([
     'layout' => 'horizontal',
     'enableClientValidation' => true,
     'enableAjaxValidation' => true,
     'validationUrl' => $validateUrl,
     'options' => ['enctype' => 'multipart/form-data'],
     'fieldConfig' => [
       'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
       'horizontalCssClasses' => [
         'wrapper' => 'col-sm-4',
         'error' => '',
         'label' => 'col-sm-2',
         'hint' => '',
       ],
     ],
   ]);?>
   <br/>
   <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>


   <?= $form->field($model, 'email',['enableAjaxValidation' => true])->textInput(['maxlength' => true,'type'=>'email']) ?>

   <?= $form->field($model, 'mobile')->textInput(['maxlength' => true,'type'=>'number']) ?>

   <?= $form->field($model, 'gender')->dropDownList(Yii::$app->myhelper->getGender(),['class'=>'form-control'])?>

   <?= $form->field($model, 'programID')->dropDownList(Yii::$app->myhelper->getProgram(),['class'=>'form-control'])?>

   <?= $form->field($model, 'collegeID')->widget(Select2::classname(), [
    'options' => ['multiple' => false,'class'=>'form-control input-sm'],
    'size' => Select2::SMALL,
    'pluginOptions' => [
      'allowClear' => true,
      'minimumInputLength' => 1,
      'language' => [
        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
      ],
      'ajax' => [
        'url' => \yii\helpers\Url::to(['user/college-list']),
        'dataType' => 'json',
        'data' => new JsExpression('function(params) { return {q:params.term}; }')
      ],
      'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
      'templateResult' => new JsExpression('function(type) { return type.text; }'),
      'templateSelection' => new JsExpression('function (type) { return type.text; }'),
    ],
  ]); ?>

   <?php

   $contriesList = UserController::actionGetCountrieslist();
   if($model->isNewRecord){
    $stateLists = UserController::actionGetStateslist();
    $citiesLists = UserController::actionGetCitieslist();
    $model->country = 101;/*india*/
    $model->state = 22;/*maharsahtra*/
  }else{
    if(!empty($model->country)){

      $stateLists = UserController::actionGetStateslist($model->country);
    }else{
      $stateLists = UserController::actionGetStateslist(101);
    }
    if(!empty($model->state)){
      $citiesLists = UserController::actionGetCitieslist($model->state);
    }else{
      $citiesLists = UserController::actionGetCitieslist(22);
    }
  }
  ?>

  <?= $form->field($model, 'country')->dropDownList(json_decode($contriesList,true),['class'=>'form-control input-sm',
    'onchange'=>'$.get("../user/get-stateslist?countryID="+$(this).val(), function( data ) {
      data = $.parseJSON(data);
      $(\'#user-state\').empty().append("<option value=\'\'>-- Select State --</option>");
      $(\'#user-city\').empty().append("<option value=\'\'>-- Select City --</option>");
      $.each(data, function(index, value) {
       $(\'#user-state\').append($(\'<option>\').text(value).attr(\'value\', index));
       });
       });
       ','prompt'=>'-- Select Country --'])?>

  <?= $form->field($model, 'state')->dropDownList(json_decode($stateLists,true),['class'=>'form-control input-sm','prompt'=>'-- Select State --',
    'onchange'=>'$.get("../user/get-citieslist?stateID="+$(this).val(), function( data ) {
     data = $.parseJSON(data);
     $(\'#user-city\').empty().append("<option value=\'\'>-- Select City --</option>");
     $.each(data, function(index, value) {
       $(\'#user-city\').append($(\'<option>\').text(value).attr(\'value\', index));
       });
       });
       '])?>

       <?= $form->field($model, 'city')->dropDownList(json_decode($citiesLists,true),['class'=>'form-control input-sm','prompt'=>'-- Select City --'])?>

       <?= $form->field($model, 'pincode')->textInput(['maxlength' => true]) ?>

       <?php
       if($model->isNewRecord){?>
         <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]);?>


         <?= $form->field($model, 'confirmpassword')->passwordInput(['maxlength' => true,'class'=>'form-control']) ?>

         <?= $form->field($model, 'roleID')->dropDownList(Yii::$app->myhelper->getRole(),['class'=>'form-control'])?>

         <?php
       }
       ?>
       <?= $form->field($model, 'status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>

       <?= $form->field($model, 'higestEduction')->textInput(['maxlength' => true]) ?>

       

       

       <div class="form-group" style="margin-left: 18% !important;">
         <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Submit') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'load' ,'data-loading-text'=>"<i class='fa fa-spinner fa-spin '></i> Processing"]) ?>
       </div>


       <?php ActiveForm::end(); ?>
     </div>
   </div>
 </div>

 <?php $this->registerJs("".Yii::$app->myhelper->formsubmitedbyajax('w0','../user/index')."");?>
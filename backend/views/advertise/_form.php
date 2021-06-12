<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use app\components\CustomUrlRule;
use dosamigos\ckeditor\CKEditor;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use yii\web\View;
use backend\controllers\UserController;

/* @var $this yii\web\View */
/* @var $model common\models\Specialization */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-articals-form">
  <div class="custumbox box box-info">
   <div class="box-body">

    <?php $form = ActiveForm::begin([
     'layout' => 'horizontal',
     'enableClientValidation' => true,
     'enableAjaxValidation' => false,
     'options' => ['enctype' => 'multipart/form-data'],
   ]);?>
   <br/>

   <?= $form->field($model, 'type')->dropDownList(Yii::$app->myhelper->getAdvertisetype(),['class'=>'form-control'])?>

   <?= $form->field($model, 'coll_univID')->widget(Select2::classname(), [
      'options' => ['placeholder' => 'Search...'],
      'data' => $coll_univID,
      'size' => Select2::SMALL,
      'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 1,
        'language' => [
          'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
        ],
        'ajax' => [
          'url' => \yii\helpers\Url::to(['advertise/search-list']),
          'dataType' => 'json',
          'data' => new JsExpression('function(params) { return {q:params.term,type:$("#advertise-type").val()}; }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('function(type) { return type.text; }'),
        'templateSelection' => new JsExpression('function (type) { return type.text; }'),
      ],
    ]);?>

   <?= $form->field($model, 'gtype')->widget(Select2::classname(), [
    'data' => Yii::$app->myhelper->getAdvertisePossition(),
    'options' => ['placeholder' => 'Select...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);?>
    
    <style type="text/css">
      #select2-advertise-college_university_advpurposeid-results{
        /*min-height: 500px !important;*/
      }
      
    </style>
    <?php
$formatJs = <<< 'JS'
var formatRepocuadd = function (repo) {
    if (repo.loading) {
        return repo.text;
    }

    if (repo.gtype == 6) {
      markup = '<div class="row">' + 
          '<div class="col-sm-5">' +
              '<video class="img-responsive" controls  controlsList="nodownload"  >' +
                '<source src="' + repo.fullpath + '" type="video/mp4">' +
               ' Your browser does not support the video tag.' +
              '</video>' +
          '</div>' +
          '<div class="col-sm-7" style="padding-left:5px">' + repo.url + '</div>' + 
      '</div>';
    }else{
      markup = '<div class="row">' + 
          '<div class="col-sm-5">' +
              '<img src="' + repo.fullpath + '" class="img-responsive" />' +
          '</div>' +
          '<div class="col-sm-7" style="padding-left:5px">' + repo.url + '</div>' + 
      '</div>';
    }
    return '<div style="overflow:hidden;">' + markup + '</div>';
};
var formatRepoSelectioncuadd = function (repo) {
    return repo.url;
}
JS;
 
// Register the formatting script
$this->registerJs($formatJs, View::POS_HEAD);
 
// script to parse the results into the format expected by Select2
$resultsJs = <<< JS
function (data, params) {
    params.page = params.page || 1;
    return {
        results: data.items,
        pagination: {
            more: (params.page * 1000) < data.total_count
        }
    };
}
JS;
// render your widget

echo $form->field($model, 'college_university_advpurposeID')->widget(Select2::classname(), [
    'options' => ['placeholder' => 'Search Program...'],
    'size' => Select2::SMALL,
    'data' => $col_uni_adv,
    'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 0,
        'language' => [
          'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
        ],
        'ajax' => [
           'url' => \yii\helpers\Url::to(['advertise/get-advertise-content']),
            'dataType' => 'json',
            'delay' => 250,
            'data' => new JsExpression('function(params) { return {q: params.term,
            type:$("#advertise-type").val(),
            coll_univID:$("#advertise-coll_univid").val(),
            gtype:$("#advertise-gtype").val()
          }; }'),
            'processResults' => new JsExpression($resultsJs),
            'cache' => true
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('formatRepocuadd'),
        'templateSelection' => new JsExpression('formatRepoSelectioncuadd'),
    ],
]);
    ?>


   <?= $form->field($model, 'programID')->widget(Select2::classname(), [
      'options' => ['placeholder' => 'Search Program...'],
      'data' => $program,
      'size' => Select2::SMALL,
      'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 1,
        'language' => [
          'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
        ],
        'ajax' => [
          'url' => \yii\helpers\Url::to(['program/program-list']),
          'dataType' => 'json',
          'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('function(type) { return type.text; }'),
        'templateSelection' => new JsExpression('function (type) { return type.text; }'),
      ],
    ]);?>


    <?= $form->field($model, 'courseID')->widget(Select2::classname(), [
      'options' => ['placeholder' => 'Search Program...'],
      'data' => $course,
      'size' => Select2::SMALL,
      'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 1,
        'language' => [
          'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
        ],
        'ajax' => [
          'url' => \yii\helpers\Url::to(['advertise/course-list']),
          'dataType' => 'json',
          'data' => new JsExpression('function(params) {
            console.log($("#advertise-coll_univid").val());
           return {q:params.term,type:$("#advertise-type").val(),coll_univID:$("#advertise-coll_univid").val(),programID:$("#advertise-programid").val()}; }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('function(type) { return type.text; }'),
        'templateSelection' => new JsExpression('function (type) { return type.text; }'),
      ],
    ]);?>



  
   <?php 
   $show_duration_days = 'none';
   if(!$model->isNewRecord){
    $fromDate = date('d-m-Y',strtotime($model->fromDate));
    $toDate = date('d-m-Y',strtotime($model->toDate));
  }else{
    $fromDate = '';
    $toDate = '';
  }
  ?>

  <?= $form->field($model, 'fromDate')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'From Date','value'=>$fromDate],
    'removeButton' => false,
    'pluginOptions' => [
      'autoclose'=>true,
      'startDate' => '-0d',
      'format' => 'dd-mm-yyyy'
    ]
  ]);?>

  <?= $form->field($model, 'toDate')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'To Date','value'=>$toDate],
    'removeButton' => false,
    'pluginOptions' => [
      'autoclose'=>true,
      'startDate' => '+1d',
      'format' => 'dd-mm-yyyy'
    ]
  ]);?>


   <?php

   $contriesList = UserController::actionGetCountrieslist();
   if($model->isNewRecord){
    $stateLists = UserController::actionGetStateslist();
    $citiesLists = UserController::actionGetCitieslist();
    $model->countryID = 101;/*india*/
    $model->stateID = 22;/*maharsahtra*/
  }else{
    if(!empty($model->country)){

      $stateLists = UserController::actionGetStateslist($model->countryID);
    }else{
      $stateLists = UserController::actionGetStateslist(101);
    }
    if(!empty($model->state)){
      $citiesLists = UserController::actionGetCitieslist($model->stateID);
    }else{
      $citiesLists = UserController::actionGetCitieslist(22);
    }
  }
  ?>

  <?= $form->field($model, 'countryID')->dropDownList(json_decode($contriesList,true),['class'=>'form-control input-sm',
    'onchange'=>'$.get("../user/get-stateslist?countryID="+$(this).val(), function( data ) {
      data = $.parseJSON(data);
      $(\'#advertise-stateID\').empty().append("<option value=\'\'>-- Select State --</option>");
      $(\'#advertise-cityid\').empty().append("<option value=\'\'>-- Select City --</option>");
      $.each(data, function(index, value) {
       $(\'#advertise-stateID\').append($(\'<option>\').text(value).attr(\'value\', index));
       });
       });
       ','prompt'=>'-- Select Country --'])?>

  <?= $form->field($model, 'stateID')->dropDownList(json_decode($stateLists,true),['class'=>'form-control input-sm','prompt'=>'-- Select State --',
    'onchange'=>'$.get("../user/get-citieslist?stateID="+$(this).val(), function( data ) {
     data = $.parseJSON(data);
     $(\'#advertise-cityid\').empty().append("<option value=\'\'>-- Select City --</option>");
     $.each(data, function(index, value) {
       $(\'#advertise-cityid\').append($(\'<option>\').text(value).attr(\'value\', index));
       });
       });
       '])?>

    <?= $form->field($model, 'cityID')->dropDownList(json_decode($citiesLists,true),['class'=>'form-control input-sm','prompt'=>'-- Select City --'])?>

    <?= $form->field($model, 'priority')->dropDownList(Yii::$app->myhelper->getPriority(),['class'=>'form-control'])?>


     <?= $form->field($model, 'description')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'standard',
    'clientOptions'=>[
      'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
      /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
    ]
  ]) ?>

  <?= $form->field($model, 'status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>

  <div class="form-group" style="margin-left: 18% !important;">
   <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Submit') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'load' ,'data-loading-text'=>"<i class='fa fa-spinner fa-spin '></i> Processing"]) ?>
 </div>


 <?php ActiveForm::end(); ?>
</div>
</div>
</div>

<?php $this->registerJs("".Yii::$app->myhelper->formsubmitedbyajax('w0','..advertise/index')."");?>
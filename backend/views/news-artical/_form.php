<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use app\components\CustomUrlRule;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use common\widgets\CKEditor;
use iutbay\yii2kcfinder\KCFinder;
use backend\controllers\UserController;

$kcfOptions = array_merge(KCFinder::$kcfDefaultOptions, [
  'uploadURL' => Yii::$app->myhelper->getFileBasePath(),
  'access' => [
    'files' => [
      'upload' => true,
      'delete' => true,
      'copy' => true,
      'move' => true,
      'rename' => true,
    ],
    'dirs' => [
      'create' => true,
      'delete' => true,
      'rename' => true,
    ],
  ],
]);

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

   <?= $form->field($model, 'natype')->dropDownList(Yii::$app->myhelper->getNewsArtical(),['class'=>'form-control'])?>

   <?= $form->field($model, 'type')->dropDownList(Yii::$app->myhelper->getUCE(),['class'=>'form-control'])?>

   <?= $form->field($model, 'coll_univ_examID')->widget(Select2::classname(), [
      'options' => ['placeholder' => 'Search...'],
      'data' => $coll_univ_examid,
      'size' => Select2::SMALL,
      'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 1,
        'language' => [
          'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
        ],
        'ajax' => [
          'url' => \yii\helpers\Url::to(['news-artical/search-list']),
          'dataType' => 'json',
          'data' => new JsExpression('function(params) { return {q:params.term,type:$("#newsartical-type").val()}; }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('function(type) { return type.text; }'),
        'templateSelection' => new JsExpression('function (type) { return type.text; }'),
      ],
    ]);?>


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

   <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

   <?= $form->field($model, 'description')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'standard',
    'clientOptions'=>[
      'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
      /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
    ]
  ]) ?>

   <?php 
   $show_duration_days = 'none';
   if(!$model->isNewRecord){
    $startDate = date('d-m-Y',strtotime($model->startDate));
    $endDate = date('d-m-Y',strtotime($model->endDate));
  }else{
    $startDate = '';
    $endDate = '';
  }
  ?>

  <?= $form->field($model, 'startDate')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Start Date','value'=>$startDate],
    'removeButton' => false,
    'pluginOptions' => [
      'autoclose'=>true,
      'startDate' => '-0d',
      'format' => 'dd-mm-yyyy'
    ]
  ]);?>

  <?= $form->field($model, 'endDate')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'End Date','value'=>$endDate],
    'removeButton' => false,
    'pluginOptions' => [
      'autoclose'=>true,
      'startDate' => '+1d',
      'format' => 'dd-mm-yyyy'
    ]
  ]);?>

  <?= $form->field($model, 'national_international')->dropDownList(Yii::$app->myhelper->getNationalInternational(),['class'=>'form-control'])?>

   <?php

   $contriesList = UserController::actionGetCountrieslist();
   if($model->isNewRecord){
    $stateLists = UserController::actionGetStateslist();
    $citiesLists = UserController::actionGetCitieslist();
    $model->countryID = 101;/*india*/
    $model->stateID = 22;/*maharsahtra*/
  }else{
    if(!empty($model->countryID)){

      $stateLists = UserController::actionGetStateslist($model->countryID);
    }else{
      $stateLists = UserController::actionGetStateslist(101);
    }
    if(!empty($model->stateID)){
      $citiesLists = UserController::actionGetCitieslist($model->stateID);
    }else{
      $citiesLists = UserController::actionGetCitieslist(22);
    }
  }
  ?>

  <?= $form->field($model, 'countryID')->dropDownList(json_decode($contriesList,true),['class'=>'form-control input-sm',
    'onchange'=>'$.get("../user/get-stateslist?countryID="+$(this).val(), function( data ) {
      data = $.parseJSON(data);
      $(\'#newsartical-stateid\').empty().append("<option value=\'\'>-- Select State --</option>");
      $(\'#newsartical-cityid\').empty().append("<option value=\'\'>-- Select City --</option>");
      $.each(data, function(index, value) {
       $(\'#newsartical-stateid\').append($(\'<option>\').text(value).attr(\'value\', index));
       });
       });
       ','prompt'=>'-- Select Country --'])?>

  <?= $form->field($model, 'stateID')->dropDownList(json_decode($stateLists,true),['class'=>'form-control input-sm','prompt'=>'-- Select State --',
    'onchange'=>'$.get("../user/get-citieslist?stateID="+$(this).val(), function( data ) {
     data = $.parseJSON(data);
     $(\'#newsartical-cityid\').empty().append("<option value=\'\'>-- Select City --</option>");
     $.each(data, function(index, value) {
       $(\'#newsartical-cityid\').append($(\'<option>\').text(value).attr(\'value\', index));
       });
       });
       '])?>

       <?= $form->field($model, 'cityID')->dropDownList(json_decode($citiesLists,true),['class'=>'form-control input-sm','prompt'=>'-- Select City --'])?>

  <?= $form->field($model, 'status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>

  <div class="form-group" style="margin-left: 18% !important;">
   <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Submit') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'load' ,'data-loading-text'=>"<i class='fa fa-spinner fa-spin '></i> Processing"]) ?>
 </div>


 <?php ActiveForm::end(); ?>
</div>
</div>
</div>

<?php $this->registerJs("".Yii::$app->myhelper->formsubmitedbyajax('w0','../news-artical/index')."");?>
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use app\components\CustomUrlRule;
use dosamigos\ckeditor\CKEditor;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UniversitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $college->name.' Add Courses Details';

$this->params['breadcrumbs'][] = ['label' => 'Colleges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $college->name;

if($model->isNewRecord){
$this->params['subtitle'] = '<h1>Add Courses Details</h1>';
$this->params['breadcrumbs'][] = "Add Courses Details";
}else{
  $this->params['subtitle'] = '<h1>Update Courses Details</h1>';
  $this->params['breadcrumbs'][] = "Update Courses Details";
}

?>
<div class="course-details-form">
  <div class="custumbox box box-info">
    <div class="box-body">
      <?php $form = ActiveForm::begin([
       'layout' => 'horizontal',
       'enableClientValidation' => true,
       'enableAjaxValidation' => false,
       'options' => ['enctype' => 'multipart/form-data'],
     ]);?>


      <?= $form->field($model, 'affiliation_type')->inline(true)->radioList(Yii::$app->myhelper->getCourseType()); ?>

      <div class="affiliation_type_2" style="display:<?= $model->affiliation_type==2?"block":"none"; ?>">
      <?= $form->field($uccModel, 'universityID')->widget(Select2::classname(), [
        'options' => ['placeholder' => 'Search University...'],
        'size' => Select2::SMALL,
        'data'=>$university,
        'pluginOptions' => [
          'allowClear' => true,

          'minimumInputLength' => 1,
          'language' => [
            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
          ],
          
          'ajax' => [
            'url' => \yii\helpers\Url::to(['university/university-list']),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { 

              return {q:params.term}; 
            }')
          ],
          'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
          'templateResult' => new JsExpression('function(type) { return type.text; }'),
          'templateSelection' => new JsExpression('function (type) { return type.text; }'),
        ],
        "pluginEvents" => [
            "select2:select" => "function() {
              $('#universitycollegecourse-courseid').val(null).trigger('change');
            }",
          ],
      ]);?>
      </div>

      
      <?= $form->field($uccModel, 'courseID')->widget(Select2::classname(), [
        'options' => ['placeholder' => 'Search Course...'],
        'size' => Select2::SMALL,
        'data'=>$course,
        'pluginOptions' => [
          'allowClear' => true,
          'minimumInputLength' => 1,
          'language' => [
            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
          ],
          'ajax' => [
            'url' => \yii\helpers\Url::to(['university/university-courses']),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { 
              return {
                q:params.term,
                affiliation_type:$("input[name=\'CourseDetails[affiliation_type]\']:checked").val(),
                universityID:$("#universitycollegecourse-universityid").val()}; }
              ')
          ],
          'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
          'templateResult' => new JsExpression('function(type) { return type.text; }'),
          'templateSelection' => new JsExpression('function (type) { return type.text; }'),
        ],
        'pluginEvents' => [
          "select2:select" => "function() {
            var sData = $(this).select2('data');
            $('#courses-programid').val(sData[0].programID);
          }",
        ]
      ]);?>

      <div class="affiliation_type_1" style="display:<?= $model->affiliation_type==1?"block":"none"; ?>">

        <?= $form->field($model, 'approved_by')->widget(Select2::classname(), [
        'options' => ['placeholder' => 'Approved By...'],
        'data' => $approved_by,
        'size' => Select2::SMALL,
        'pluginOptions' => [
          'allowClear' => true,
          'multiple' => true,
          'minimumInputLength' => 1,
          'language' => [
            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
          ],
          'ajax' => [
            'url' => \yii\helpers\Url::to(['approved/approved-by-list']),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
          ],
          'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
          'templateResult' => new JsExpression('function(type) { return type.text; }'),
          'templateSelection' => new JsExpression('function (type) { return type.text; }'),
        ],
      ]);?>
      
        <?= $form->field($model, 'course_mode')->dropDownList(Yii::$app->myhelper->getCourseMode(),['class'=>'form-control','prompt'=>'Select Course Mode'])?>

        <?= $form->field($model, 'eligibility_criteria')->widget(CKEditor::className(), [
          'options' => ['rows' => 6],
          'preset' => 'standard',
          'clientOptions'=>[
            'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
            /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
          ]
        ]) ?>

        <?= $form->field($model, 'course_curriculum')->widget(CKEditor::className(), [
          'options' => ['rows' => 6],
          'preset' => 'standard',
          'clientOptions'=>[
            'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
            /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
          ]
        ]) ?>

        <?= Html::hiddenInput('name', (isset($uccModel->course->programID)?$uccModel->course->programID:""),['id'=>'courses-programid']); ?>

        <?= $form->field($model, 'entrance_exams_accepted')->widget(Select2::classname(), [
          'options' => ['placeholder' => 'Search Program...','multiple' => true],
          'data' => $exams,
          'size' => Select2::SMALL,
          'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 1,
            'language' => [
              'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
              'url' => \yii\helpers\Url::to(['exam/exam-list']),
              'dataType' => 'json',
              'data' => new JsExpression('function(params) { 
                console.log($("#courses-programid").val());
                return {q:params.term,programID:$("#courses-programid").val()}; 
              }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(type) { return type.text; }'),
            'templateSelection' => new JsExpression('function (type) { return type.text; }'),
          ],
        ]);?>
      </div>
      
      <?= $form->field($model, 'fees')->textInput(['maxlength' => true]) ?>
      
      <?= $form->field($model, 'fee_breakup')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'standard',
        'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
        ]
      ]) ?>

      <?= $form->field($model, 'admission_process')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'standard',
        'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
        ]
      ]) ?>

      <?= $form->field($model, 'important_dates')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'standard',
        'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
        ]
      ]) ?>


      <?= $form->field($model, 'course_credits')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'standard',
        'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
        ]
      ]) ?>

      <?= $form->field($model, 'seat_breakup')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'standard',
        'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
        ]
      ]) ?>


      <?= $form->field($model, 'approved_intake')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'standard',
        'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
        ]
      ]) ?>

      <?= $form->field($model, 'start_year')->textInput(['maxlength' => true]) ?>

      <?= $form->field($model, 'accreditation_status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>

      <?= $form->field($model, 'nri_quota')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'standard',
        'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
        ]
      ]) ?>

      <?= $form->field($model, 'jk_quota')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'standard',
        'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
        ]
      ]) ?>

      <?= $form->field($model, 'foreign_collaboration')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'standard',
        'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
        ]
      ]) ?>

      <?= $form->field($model, 'foreign_university')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'standard',
        'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
        ]
      ]) ?>

      <?= $form->field($model, 'placement_data')->dropDownList(Yii::$app->myhelper->getPlacementData(),['class'=>'form-control'])?>

      <?= $form->field($model, 'register_url')->textInput(['maxlength' => true]) ?>

      <?= $form->field($model, 'shift')->dropDownList(Yii::$app->myhelper->getShift(),['class'=>'form-control'])?>

      <?= $form->field($model, 'status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>

      <div class="form-group" style="margin-left: 18% !important;">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Submit') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'load' ,'data-loading-text'=>"<i class='fa fa-spinner fa-spin '></i> Processing"]) ?>
      </div>

      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>
<?php 
$this->registerCss("
  .app-title{
    display: none;
  }
  ");
?>

<?php 
  $this->registerJs("".Yii::$app->myhelper->formsubmitedbyajax('w0','../university/index')."");
  $this->registerJs("
    $('#coursedetails-affiliation_type').change(function(e){
      var affiliation_type = $('input[name=\"CourseDetails[affiliation_type]\"]:checked').val();
      if(affiliation_type == 1)
      {
        $('.affiliation_type_1').show();
        $('.affiliation_type_2').hide();

      }else{
        $('.affiliation_type_1').hide();
        $('.affiliation_type_2').show();
      }

    });
  ");
?>
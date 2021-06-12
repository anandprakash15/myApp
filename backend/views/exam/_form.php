<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use app\components\CustomUrlRule;
use common\widgets\CKEditor;
use iutbay\yii2kcfinder\KCFinder;

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

Yii::$app->session->set('KCFINDER', $kcfOptions);
/* @var $this yii\web\View */
/* @var $model common\models\Specialization */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="exam-category-form">
    <div class="custumbox box box-info">
     <div class="box-body">

        <?php $form = ActiveForm::begin([
         'layout' => 'horizontal',
         'enableClientValidation' => true,
         'enableAjaxValidation' => false,
         'options' => ['enctype' => 'multipart/form-data'],
     ]);?>
     <br/>

     <?= $form->field($model, 'exam_name')->textInput(['maxlength' => true]) ?>
     <?= $form->field($model, 'short_code')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'programID')->widget(Select2::classname(), [
        'options' => ['placeholder' => 'Search...'],
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
        'options' => ['placeholder' => 'Search...'],
        'data' => $course,
        'size' => Select2::SMALL,
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 1,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
                'url' => \yii\helpers\Url::to(['courses/course-list']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(type) { return type.text; }'),
            'templateSelection' => new JsExpression('function (type) { return type.text; }'),
        ],
    ]);?>

  <?= $form->field($model, 'exam_course_level')->dropDownList(Yii::$app->myhelper->getCourseLevel(),['class'=>'form-control'])?>

  <?= $form->field($model, 'exam_level')->dropDownList(Yii::$app->myhelper->getExamLevel(),['class'=>'form-control'])?>

  <?php 
    $model->exam_mode = ($model->isNewRecord)?'1':$model->exam_mode;
  ?>
  <?= $form->field($model, 'exam_mode')->inline(true)->radioList(Yii::$app->myhelper->getExamMode()); ?>

  <?= $form->field($model, 'conducting_authority')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'language_of_paper')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?> 

  <?= $form->field($model, 'highlights')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'eligibility_criteria')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>
  <?= $form->field($model, 'registration_fees')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>
  <?= $form->field($model, 'late_fees')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>
  <?= $form->field($model, 'registration_start_date')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>
  <?= $form->field($model, 'registration_start_time')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>
  <?= $form->field($model, 'registration_end_date')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'registration_closing_time')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'registration_extended_date_from')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

    <?= $form->field($model, 'registration_extended_date_to')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

    <?= $form->field($model, 'admit_card_download_start_date')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

    <?= $form->field($model, 'admit_card_download_end_date')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

    <?= $form->field($model, 'online_exam_date')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

    <?= $form->field($model, 'paper_based_exam_date')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'result_date')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'exam_registration_website')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'exam_helpline_nos')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'helpline_emails')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'registration_process')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'registration_documents')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'exam_duration')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>


  <?= $form->field($model, 'total_marks')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>


  <?= $form->field($model, 'marks_per_question')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

    <?= $form->field($model, 'negative_marks_per_question')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'no_of_questions')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>


  <?= $form->field($model, 'exam_pattern')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'number_of_exam_cities')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>


  <?= $form->field($model, 'exam_centres')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'cut_off')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'syllabus')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'exam_books_guide')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'question_papers')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'do_dont_during_the_exam')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'results')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'analysis')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'exam_FAQ')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'preparation_tips')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
  ]) ?>

  <?= $form->field($model, 'coaching_classes')->widget(CKEditor::className(), [
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

<?php $this->registerJs("".Yii::$app->myhelper->formsubmitedbyajax('w0','../exam/index')."");?>
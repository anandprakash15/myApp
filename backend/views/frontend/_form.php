<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
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
/* @var $this yii\web\View */
/* @var $model common\models\Specialization */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="frontend-form">
  <div class="custumbox box box-info">
   <div class="box-body">

    <?php $form = ActiveForm::begin([
     'layout' => 'horizontal',
     'enableClientValidation' => true,
     'enableAjaxValidation' => false,
     'options' => ['enctype' => 'multipart/form-data'],
   ]);?>
   <br/>

   <?= $form->field($model, 'about')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'standard',
    'clientOptions'=>[
      'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
      /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
    ]
  ]) ?>

  <?= $form->field($model, 'about_status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>

  <?= $form->field($model, 'privacy')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'standard',
    'clientOptions'=>[
      'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
      /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
    ]
  ]) ?>

  <?= $form->field($model, 'privacy_status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>

  <?= $form->field($model, 'term_condition')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'standard',
    'clientOptions'=>[
      'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
      /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
    ]
  ]) ?>

  <?= $form->field($model, 'term_condition_status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>


  <?= $form->field($model, 'vision')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'standard',
    'clientOptions'=>[
      'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
      /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
    ]
  ]) ?>

  <?= $form->field($model, 'vision_status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>


  <?= $form->field($model, 'mission')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'standard',
    'clientOptions'=>[
      'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
      /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
    ]
  ]) ?>

  <?= $form->field($model, 'mission_status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>

  <?= $form->field($model, 'disclaimer')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'standard',
    'clientOptions'=>[
      'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
      /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
    ]
  ]) ?>

  <?= $form->field($model, 'disclaimer_status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>

  <?= $form->field($model, 'faq')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'standard',
    'clientOptions'=>[
      'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
      /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
    ]
  ]) ?>

  <?= $form->field($model, 'faq_status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>

  <?= $form->field($model, 'contact_us')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'standard',
    'clientOptions'=>[
      'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
      /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
    ]
  ]) ?>

  <?= $form->field($model, 'contact_us_status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>

  <?= $form->field($model, 'site_map')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'standard',
    'clientOptions'=>[
      'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
      /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
    ]
  ]) ?>

  <?= $form->field($model, 'site_map_status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>


  <?= $form->field($model, 'why_choose_us')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'standard',
    'clientOptions'=>[
      'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
      /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
    ]
  ]) ?>

  <?= $form->field($model, 'wcu_status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>


  <?= $form->field($model, 'management_team')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'standard',
    'clientOptions'=>[
      'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
      /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
    ]
  ]) ?>

  <?= $form->field($model, 'mt_status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>




  <?= $form->field($model, 'careers')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'standard',
    'clientOptions'=>[
      'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
      /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
    ]
  ]) ?>

  <?= $form->field($model, 'careers_status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>

  <?= $form->field($model, 'our_blog')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'standard',
    'clientOptions'=>[
      'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
      /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
    ]
  ]) ?>

  <?= $form->field($model, 'ob_status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>




  <div class="form-group" style="margin-left: 18% !important;">
    <button id="back_btn" class="btn btn-default"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Submit') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'load' ,'data-loading-text'=>"<i class='fa fa-spinner fa-spin '></i> Processing"]) ?>
  </div>


  <?php ActiveForm::end(); ?>
</div>
</div>
</div>

<?php $this->registerJs("".Yii::$app->myhelper->formsubmitedbyajax('w0','../frontend/index')."");?>
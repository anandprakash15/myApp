<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use app\components\CustomUrlRule;
use dosamigos\ckeditor\CKEditor;
use backend\controllers\UserController;

/* @var $this yii\web\View */
/* @var $model common\models\Specialization */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accreditation -form">
    <div class="custumbox box box-info">
       <div class="box-body">

        <?php $form = ActiveForm::begin([
         'layout' => 'horizontal',
         'enableClientValidation' => true,
         'enableAjaxValidation' => false,
         'options' => ['enctype' => 'multipart/form-data'],
     ]);?>
     <br/>
     <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'shortname')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'description')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
        'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
        /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
    ]) ?>

       <?php

   $contriesList = UserController::actionGetCountrieslist();
   if($model->isNewRecord){
    $model->countryID = 101;/*india*/
  }
  ?>

  <?= $form->field($model, 'countryID')->dropDownList(json_decode($contriesList,true),['class'=>'form-control','prompt'=>'-- Select Country --'])?>

     <?= $form->field($model, 'status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>

     <div class="form-group" style="margin-left: 18% !important;">
       <button id="back_btn" class="btn btn-default"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
       <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Submit') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'load' ,'data-loading-text'=>"<i class='fa fa-spinner fa-spin '></i> Processing"]) ?>
   </div>


   <?php ActiveForm::end(); ?>
</div>
</div>
</div>

<?php $this->registerJs("".Yii::$app->myhelper->formsubmitedbyajax('w0','../affiliate/index')."");?>
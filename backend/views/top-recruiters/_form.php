<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditor;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\TopRecruiters */
/* @var $form yii\widgets\ActiveForm */


$logoImgPreview = '';
if(!empty($model->logo)){
  $logoImgPreview = [Yii::$app->myhelper->trLogoViewUrl.$model->logo];
}
?>

<div class="top-recruiters-form">
  <div class="custumbox box box-info">
   <div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'industry_sectorID')->dropDownList(Yii::$app->myhelper->getIndustrySector(),['class'=>'form-control','prompt'=>'-- Select Industry Sector --'])?>

    <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>


    <?php echo $form->field($model, 'logoImg')->widget(FileInput::classname(), [
        'pluginOptions' => [
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            'options' => ['multiple' => false],
            'initialPreview'=> $logoImgPreview,
            'initialPreviewConfig'=>[
                [
                    'downloadUrl'=> $logoImgPreview,
                    'url'=>($model->id)? Url::to(['delete-file','id'=>$model->id]):'',
                ]
            ],
            'initialPreviewAsData'=>true,
            'overwriteInitial'=>true,
            'dropZoneEnabled'=> false,
            'showCaption' => true,
            'showRemove' => false,
            'showUpload' => false,
        ],
    ]);?>

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
        <button id="back_btn" class="btn btn-default"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
       <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Submit') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'load' ,'data-loading-text'=>"<i class='fa fa-spinner fa-spin '></i> Processing"]) ?>
   </div>


 <?php ActiveForm::end(); ?>
</div>
</div>
</div>

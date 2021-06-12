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

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UniversitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $universityandcourse->university->name.' Add Courses Details';
$this->params['subtitle'] = '<h1>Add Courses Details</h1>';
$this->params['breadcrumbs'][] = ['label' => 'Universities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $universityandcourse->university->name;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['courses','id'=>$universityandcourse->university->id]];
$this->params['breadcrumbs'][] = ['label' => $universityandcourse->course->name, 'url' => ['courses','id'=>$universityandcourse->university->id]];
$this->params['breadcrumbs'][] = 'Details';
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

            <?php /*echo $form->field($model, 'course_mode')->dropDownList(Yii::$app->myhelper->getCourseMode(),['class'=>'form-control','prompt'=>'Select Course Mode'])*/ ?>

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

            <?= Html::hiddenInput('name', $universityandcourse->course->programID,['id'=>'courses-programid']); ?>
            <?php /*echo $form->field($model, 'entrance_exams_accepted')->widget(Select2::classname(), [
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
            ]);*/ ?>

            

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

            <?= $form->field($model, 'register_url')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>

            <div class="form-group" style="margin-left: 18% !important;">
                <button id="back_btn" class="btn btn-default"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
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

<?php $this->registerJs("".Yii::$app->myhelper->formsubmitedbyajax('w0','../university/index')."");?>

<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\widgets\SwitchInput;
use yii\helpers\ArrayHelper;
use app\models\User;
use kartik\widgets\FileInput;
use app\components\CustomUrlRule;

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

     <?= $form->field($model, 'programID')->dropDownList(Yii::$app->myhelper->getProgram(),['class'=>'form-control'])?>

     <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>

     <div class="form-group" style="margin-left: 18% !important;">
       <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Submit') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'load' ,'data-loading-text'=>"<i class='fa fa-spinner fa-spin '></i> Processing"]) ?>
   </div>


   <?php ActiveForm::end(); ?>
</div>
</div>
</div>

<?php $this->registerJs("".Yii::$app->myhelper->formsubmitedbyajax('w0','../exam-category/index')."");?>
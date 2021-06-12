<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\widgets\StarRating;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UniversitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $college->name.' Review Details';
$this->params['subtitle'] = '<h1>Review Details</h1>';
$this->params['breadcrumbs'][] = ['label' => 'Colleges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $college->name;
$this->params['breadcrumbs'][] = ['label' =>$model->createdBy0->fullname , 'url' => ['user/update','id'=>$model->createdBy0->id]];
$this->params['breadcrumbs'][] = 'Review Details';
?>
<div class="course-details-form box box-info">
   <div class="box-header with-border">
      <h4 class="box-title">Name: <?= $model->createdBy0->fullname ?>  
      <?php if(!empty($model->course)){ ?>
        / Course: <?= $model->course->name ?>
      <?php } ?>
    </h4>
   </div>
  <div class="box-body">
    <div class="box-border box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Placement</h3>
        <div class="box-tools pull-right">
          <?php
          echo StarRating::widget([
            'name' => 'rating_2',
            'value' => $model->placement_star,
            'disabled' => true,
            'pluginOptions' => [
              'readonly' => true,
              'showClear' => false,
              'showCaption' => false,
              'size' => 'sm'
            ],
          ]);
          ?>
        </div>
      </div>
      <div class="box-body">
        <p><?= $model->placement_review ?></p>
      </div>
    </div>

    <div class="box-border box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Infrastructure</h3>
        <div class="box-tools pull-right">
          <?php
          echo StarRating::widget([
            'name' => 'rating_2',
            'value' => $model->infrastructure_star,
            'disabled' => true,
            'pluginOptions' => [
              'readonly' => true,
              'showClear' => false,
              'showCaption' => false,
              'size' => 'sm'
            ],
          ]);
          ?>
        </div>
      </div>
      <div class="box-body">
        <p><?= $model->infrastructure_review ?></p>
      </div>
    </div>

    <div class="box-border box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">FCC</h3>
        <div class="box-tools pull-right">
          <?php
          echo StarRating::widget([
            'name' => 'rating_2',
            'value' => $model->fcc_star,
            'disabled' => true,
            'pluginOptions' => [
              'readonly' => true,
              'showClear' => false,
              'showCaption' => false,
              'size' => 'sm'
            ],
          ]);
          ?>
        </div>
      </div>
      <div class="box-body">
        <p><?= $model->fcc_review ?></p>
      </div>
    </div>

    <div class="box-border box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">CCL</h3>
        <div class="box-tools pull-right">
          <?php
          echo StarRating::widget([
            'name' => 'rating_2',
            'value' => $model->ccl_star,
            'disabled' => true,
            'pluginOptions' => [
              'readonly' => true,
              'showClear' => false,
              'showCaption' => false,
              'size' => 'sm'
            ],
          ]);
          ?>
        </div>
      </div>
      <div class="box-body">
        <p><?= $model->ccl_star ?></p>
      </div>
    </div>

    <div class="box-border box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">CCT</h3>
        <div class="box-tools pull-right">
          <?php
          echo StarRating::widget([
            'name' => 'rating_2',
            'value' => $model->cct_review,
            'disabled' => true,
            'pluginOptions' => [
              'readonly' => true,
              'showClear' => false,
              'showCaption' => false,
              'size' => 'sm'
            ],
          ]);
          ?>
        </div>
      </div>
      <div class="box-body">
        <p><?= $model->cct_review ?></p>
      </div>
    </div>


    <div class="box-border box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">WTD</h3>
        <div class="box-tools pull-right">
          <?php
          echo StarRating::widget([
            'name' => 'rating_2',
            'value' => $model->wtd_star,
            'disabled' => true,
            'pluginOptions' => [
              'readonly' => true,
              'showClear' => false,
              'showCaption' => false,
              'size' => 'sm'
            ],
          ]);
          ?>
        </div>
      </div>
      <div class="box-body">
        <p><?= $model->wtd_review ?></p>
      </div>
    </div>

    <div class="box-border box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Other</h3>
        <div class="box-tools pull-right">
          <?php
          echo StarRating::widget([
            'name' => 'rating_2',
            'value' => $model->other_star,
            'disabled' => true,
            'pluginOptions' => [
              'readonly' => true,
              'showClear' => false,
              'showCaption' => false,
              'size' => 'sm'
            ],
          ]);
          ?>
        </div>
      </div>
      <div class="box-body">
        <p><?= $model->other_review ?></p>
      </div>
    </div>



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
        'label' => 'col-sm-4',
        'hint' => '',
      ],
    ],
  ]);?>
  <?= $form->field($model, 'status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>

  <div class="text-center">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Submit') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'load' ,'data-loading-text'=>"<i class='fa fa-spinner fa-spin '></i> Processing"]) ?>
  </div>

  <?php ActiveForm::end(); ?>
</div>
</div>

<?php 
$this->registerCss("
  .app-title{
    display: none;
  }
  ");
  ?>

  <?php $this->registerJs("".Yii::$app->myhelper->formsubmitedbyajax('w0','../college/index')."");?>
<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use app\components\CustomUrlRule;
use backend\controllers\UserController;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use common\widgets\CKEditor;
use iutbay\yii2kcfinder\KCFinder;

/* @var $this yii\web\View */
/* @var $model common\models\Specialization */
/* @var $form yii\widgets\ActiveForm */

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
$validateUrl = ($model->isNewRecord)?Url::to(['college/validate']):Url::to(['college/validate','id'=>$model->id]);
?>

<div class="exam-category-form">
  <div class="custumbox box box-info">
   <div class="box-body">

    <?php $form = ActiveForm::begin([
     'layout' => 'horizontal',
     'enableClientValidation' => true,
     'enableAjaxValidation' => true,
     'validationUrl' => $validateUrl,
     'options' => ['enctype' => 'multipart/form-data'],
   ]);?>
   <br/>

   <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


   <?= $form->field($model, 'sortname')->textInput(['maxlength' => true]) ?>


    <?php if (!$model->isNewRecord) {
        $model->code = Yii::$app->myhelper->getCollegeCode($model->code);
      ?>
      <?= $form->field($model, 'code',['enableAjaxValidation' => true])->textInput(['maxlength' => true,'disabled'=>true]) ?>
    <?php } ?>


   <?= $form->field($model, 'ctype')->dropDownList(Yii::$app->myhelper->getCollegetype(),['class'=>'form-control'])?>

   <?= $form->field($model, 'address')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'standard',
    'clientOptions'=>[
      'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
      /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
    ]
  ]) ?>

   <?= $form->field($model, 'area')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model, 'taluka')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model, 'district')->textInput(['maxlength' => true]) ?>

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
      $(\'#college-stateid\').empty().append("<option value=\'\'>-- Select State --</option>");
      $(\'#college-cityid\').empty().append("<option value=\'\'>-- Select City --</option>");
      $.each(data, function(index, value) {
       $(\'#college-stateid\').append($(\'<option>\').text(value).attr(\'value\', index));
       });
       });
       ','prompt'=>'-- Select Country --'])?>

  <?= $form->field($model, 'stateID')->dropDownList(json_decode($stateLists,true),['class'=>'form-control input-sm','prompt'=>'-- Select State --',
    'onchange'=>'$.get("../user/get-citieslist?stateID="+$(this).val(), function( data ) {
     data = $.parseJSON(data);
     $(\'#college-cityid\').empty().append("<option value=\'\'>-- Select City --</option>");
     $.each(data, function(index, value) {
       $(\'#college-cityid\').append($(\'<option>\').text(value).attr(\'value\', index));
       });
       });
       '])?>

       <?= $form->field($model, 'cityID')->dropDownList(json_decode($citiesLists,true),['class'=>'form-control input-sm','prompt'=>'-- Select City --'])?>

       <?= $form->field($model, 'pincode')->textInput(['maxlength' => true]) ?>

       <?= $form->field($model, 'contact')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'standard',
        'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
        ]
      ]) ?>


      <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>

      <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

      <?= $form->field($model, 'websiteurl')->textInput(['maxlength' => true]) ?>

      <?= $form->field($model, 'establish_year')->textInput(['maxlength' => true]) ?>

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


      <?= $form->field($model, 'accredited_by')->widget(Select2::classname(), [
        'options' => ['placeholder' => 'Accredited By...'],
        'data' => $accredited_by,
        'size' => Select2::SMALL,

        'pluginOptions' => [
          'allowClear' => true,
          'multiple' => true,
          'minimumInputLength' => 1,
          'language' => [
            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
          ],
          'ajax' => [
            'url' => \yii\helpers\Url::to(['accredited/accredited-by-list']),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
          ],
          'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
          'templateResult' => new JsExpression('function(type) { return type.text; }'),
          'templateSelection' => new JsExpression('function (type) { return type.text; }'),
        ],
      ]);?>


      <?= $form->field($model, 'affiliate_to')->widget(Select2::classname(), [
        'options' => ['placeholder' => 'Affiliate To...'],
        'data' => $affiliate_to,
        'size' => Select2::SMALL,

        'pluginOptions' => [
          'allowClear' => true,
          'multiple' => true,
          'minimumInputLength' => 1,
          'language' => [
            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
          ],
          'ajax' => [
            'url' => \yii\helpers\Url::to(['affiliate/affiliate-list']),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
          ],
          'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
          'templateResult' => new JsExpression('function(type) { return type.text; }'),
          'templateSelection' => new JsExpression('function (type) { return type.text; }'),
        ],
      ]);?>

      <?= $form->field($model, 'rating')->textInput(['maxlength' => true]) ?>

      <?= $form->field($model, 'about')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'standard',
        'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
        ]
      ]) ?>

      <?= $form->field($model, 'vission')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'standard',
        'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
        ]
      ]) ?>

      <?= $form->field($model, 'mission')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'standard',
        'clientOptions'=>[
          'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,flag',
          /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
        ]
      ]) ?>

      <?= $form->field($model, 'ownership')->dropDownList(Yii::$app->myhelper->getOwnership(),['class'=>'form-control','prompt'=>'Select Ownership'])?>

      <?php
      $bannerImgPreview = $brochureFilePreview = $logoImgPreview = "";
      if(!$model->isNewRecord){

        $fViewPath= Yii::$app->myhelper->getFileBasePath(2,$model->id);
        if(!empty($model->bannerURL)){
          $bannerImgPreview = [$fViewPath.$model->bannerURL];
        }
        if(!empty($model->brochureurl)){
          $brochureFilePreview = $fViewPath.$model->brochureurl;
        }
        if(!empty($model->logourl)){
          $logoImgPreview = [$fViewPath.$model->logourl];
        }

      }

      ?>


      <?php echo $form->field($model, 'bannerImg')->widget(FileInput::classname(), [
        'pluginOptions' => [
          'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
          'options' => ['multiple' => false,'accept' => 'image/*'],
          'initialPreview'=> $bannerImgPreview,
          'initialPreviewAsData'=>true,
          'initialPreviewFileType'=> 'image',
          'initialPreviewConfig'=>[[
            'downloadUrl'=>$bannerImgPreview,
            'url'=>($model->id)? Url::to(['delete-file','id'=>$model->id,'property'=>'bannerURL']):'',
            'extra'=> ['id'=> 100],
            'key'=>1
          ]
        ],
        'overwriteInitial'=>true,
        'dropZoneEnabled'=> false,
        'showCaption' => true,
        'showRemove' => false,
        'showUpload' => false,
      ],
      'pluginEvents'=>[
        'filebeforedelete'=>'function(){
          return new Promise(function(resolve, reject) {
            $.confirm({
              title: "Confirmation!",
              content: "Are you sure you want to delete this file?",
              type: "red",
              buttons: {   
                ok: {
                  btnClass: "btn-primary text-white",
                  keys: ["enter"],
                  action: function(){
                   console.log();
                   resolve();

                 }
                 },
                 cancel: function(){
                  $.alert("File deletion was aborted! ");
                }
              }
              });
              }); 
            }',
          ],
        ]);?>


        <?php echo $form->field($model, 'brochureFile')->widget(FileInput::classname(), [
          'pluginOptions' => [
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            'options' => ['multiple' => false],
            'initialPreview'=> $brochureFilePreview,
            'initialPreviewAsData'=>true,
            'initialPreviewConfig'=>[[
              'downloadUrl'=> $brochureFilePreview,
              'url'=>($model->id)? Url::to(['delete-file','id'=>$model->id,'property'=>'brochureurl']):'',
              'extra'=> ['id'=> 100],
              'key'=>1
            ]
          ],
          'preferIconicPreview'=> true,
          'initialPreviewFileType'=> 'image',
          'previewFileIconSettings'=>[
            'docx'=> '<i class="fa fa-file text-primary"></i>',
            'doc'=> '<i class="fa fa-file text-primary"></i>',
            'xls'=> '<i class="fa fa-file-excel text-success"></i>',
            'ppt'=> '<i class="fa fa-file-powerpoint text-danger"></i>',
          ],
          'previewFileExtSettings'=>[
            /*'doc'=> 'function(ext) {
              return ext.match(/(doc|docx)$/i);
            }',*/
          ],
          
          'overwriteInitial'=>true,
          'dropZoneEnabled'=> false,
          'showCaption' => true,
          'showRemove' => false,
          'showUpload' => false,
        ]
      ]);?>

        <?php echo $form->field($model, 'logoImg')->widget(FileInput::classname(), [
          'pluginOptions' => [
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            'options' => ['multiple' => false,'accept' => 'image/*'],
            'initialPreview'=> $logoImgPreview,
            'initialPreviewAsData'=>true,
            'initialPreviewFileType'=> 'image',
            'initialPreviewConfig'=>[[
              'downloadUrl'=>$logoImgPreview,
              'url'=>($model->id)? Url::to(['delete-file','id'=>$model->id,'property'=>'logourl']):'',
              'extra'=> [],
              'key'=>1
            ]
          ],
          'overwriteInitial'=>true,
          'dropZoneEnabled'=> false,
          'showCaption' => true,
          'showRemove' => false,
          'showUpload' => false,
          'uploadAsync'=>false,
        ],
        'pluginEvents'=>[
          'filebeforedelete'=>'function(){
            return new Promise(function(resolve, reject) {
              $.confirm({
                title: "Confirmation!",
                content: "Are you sure you want to delete this file?",
                type: "red",
                buttons: {   
                  ok: {
                    btnClass: "btn-primary text-white",
                    keys: ["enter"],
                    action: function(){
                     console.log();
                     resolve();

                   }
                   },
                   cancel: function(){
                    $.alert("File deletion was aborted! ");
                  }
                }
                });
                }); 
              }',
            ]
          ]);?>

      <?= $form->field($model, 'status')->dropDownList(Yii::$app->myhelper->getActiveInactive(),['class'=>'form-control'])?>

      <div class="form-group" style="margin-left: 18% !important;">
       <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Submit') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'load' ,'data-loading-text'=>"<i class='fa fa-spinner fa-spin '></i> Processing"]) ?>
     </div>

     <?php ActiveForm::end(); ?>

   </div>

   <?php $this->registerJs("".Yii::$app->myhelper->formsubmitedbyajax('w0','../college/index')."");?>
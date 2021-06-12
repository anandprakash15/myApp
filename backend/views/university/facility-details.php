<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use app\components\CustomUrlRule;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UniversitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

if($model->isNewRecord){

  $this->title = $university->name.' Add Facility';
  $this->params['subtitle'] = '<h1>Add Facility</h1>';
  $this->params['breadcrumbs'][] = ['label' => 'Universities', 'url' => ['index']];
  $this->params['breadcrumbs'][] = $university->name;
  $this->params['breadcrumbs'][] = 'Add Facility';
}else{
  $this->title = $university->name.' Update Facility';
  $this->params['subtitle'] = '<h1>Update Facility</h1>';
  $this->params['breadcrumbs'][] = ['label' => 'Universities', 'url' => ['index']];
  $this->params['breadcrumbs'][] = $university->name;
  $this->params['breadcrumbs'][] = 'Update Facility';
}

$this->registerCssFile("@web/css/lightgallery.min.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);

$this->registerCssFile("@web/css/video-js.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);

$this->registerJsFile('@web/js/imagesloaded.pkgd.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/isotope.pkgd.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/picturefill.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/lightgallery-all.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/jquery.mousewheel.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/video.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/lg-deletebutton.js',['depends' => [\yii\web\JqueryAsset::className()]]);

echo Yii::$app->message->display();
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


     <?= $form->field($model, 'ftype')->dropDownList(Yii::$app->myhelper->getFacility(),['class'=>'form-control'])?>

     <?= $form->field($model, 'description')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'standard',
      'clientOptions'=>[
        'removePlugins' => 'save,newpage,print,pastetext,pastefromword,forms,language,flash,spellchecker,about,smiley,div,image,flag',
        /* 'filebrowserUploadUrl' => Url::to(['course-documents/upload-image']),*/
      ]
    ]) ?>

     <?= $form->field($facilityGallery, 'imagevideo[]')->widget(FileInput::classname(), [
      'options' => ['multiple' => true],
      'pluginOptions' => [
        'showUpload' => false,
        'overwriteInitial'=>false,
        'dropZoneEnabled'=>false,
        'uploadUrl' => false,
        //'allowedPreviewTypes'=> ["image", "video"],
        //'initialPreviewFileType'=>["image", "video"],
        //'allowedPreviewTypes' => ['image','video'],
        'initialPreviewAsData'=>true,
        'allowedFileExtensions' => ['jpg','jpeg','png','gif','mp4'],
        //'initialPreview'=> ArrayHelper::getColumn($initialPreviewConfig,'fileurl'),
        //'initialPreviewConfig'=>$initialPreviewConfig
      ],
    ]); ?>

    <?php if (!empty($images)) {?>
      <div class="form-group">
        <div class="control-label col-sm-2">Uploaded Images</div>
        <div class="col-md-10">
          <div class="col-md-12 lightgallery masonry-container box-body box-comments">
            <?php foreach ($images as $key => $file) { ?>
              <div class="col-md-3  masonry-item">
                <?php 
                $encID=Yii::$app->myhelper->getEncryptID($file->id);
                $fileUrl = $fBasePath.$file->url;
                ?>
                <div class="gallery-file-wrap" data-src="<?= $fileUrl ?>">
                  <img class="img-responsive img-thumbnail" src="<?= $fileUrl  ?>" data-key="<?= Url::to(['university/facility-gallery-delete','id'=>$file->id,'key'=>$encID]) ?>" />
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php } ?>

    <?php if (!empty($videos)) {?>
      <div class="form-group">
        <div class="control-label col-sm-2">Uploaded Videos</div>
        <div class="col-md-10">
          <div class="custumbox box box-solid ">
            <div class="lightgallery masonry-container box-body box-comments">
              <?php foreach ($videos as $key => $file) { ?>
                <div class="col-md-3  masonry-item">
                  <?php 
                  $encID=Yii::$app->myhelper->getEncryptID($file->id);
                  $videoID= "video".$key;
                  $fileUrl = $fBasePath.$file->url;
                  $thumbPath =  $fBasePath.pathinfo($fileUrl, PATHINFO_FILENAME)."-thumb.png";
                  ?>
                  <div style="display:none;" id="<?=$videoID?>">
                    <video class="lg-video-object lg-html5 video-js vjs-default-skin vjs-big-play-button" 
                    poster="<?= $thumbPath ?>"
                    controls preload="none">
                    <source src="<?=$fileUrl?>" type="video/mp4">
                      Your browser does not support HTML5 video.
                    </video>
                  </div>
                  <div class="gallery-file-wrap" data-poster="<?= $thumbPath ?>"  data-html="#<?= $videoID ?>" >
                    <img class="img-responsive img-thumbnail" src="<?= $thumbPath ?>" data-key="<?= Url::to(['university/facility-gallery-delete','id'=>$file->id,'key'=>$encID]) ?>" />
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>


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

$this->registerJs('
  $masonry = $(".masonry-container");
  $(document).ready(function(){
    function initFunctions(){
      $lg = $(".lightgallery");
      $lg.lightGallery({
        selector:".gallery-file-wrap",
        videojs: true,
        share: false,
        download: false,
        });

        $masonry.isotope({
          itemSelector: ".masonry-item",
          columnWidth: "25%",
          percentPosition: true,
        });

        $masonry.imagesLoaded().progress( function() {
          $masonry.isotope("layout");
        });

          $lg.on("onBeforeClose.lg",function(event, index, fromTouch, fromThumb){
            reloadMasonry();
            });
          }

          initFunctions();
          function reloadMasonry(){
            $(".masonry-container").isotope("reloadItems");
            $(".masonry-container").isotope("layout");
          }
          });
          ');
          ?>
          <?php $this->registerJs("".Yii::$app->myhelper->formsubmitedbyajax('w0','../university/index')."");?>
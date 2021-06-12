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

  $this->title = $college->name.' Add Facility';
  $this->params['subtitle'] = '<h1>Add Facility</h1>';
  $this->params['breadcrumbs'][] = ['label' => 'College', 'url' => ['index']];
  $this->params['breadcrumbs'][] = $college->name;
  $this->params['breadcrumbs'][] = 'Add Facility';
}else{
  $this->title = $college->name.' Update Facility';
  $this->params['subtitle'] = '<h1>Update Facility</h1>';
  $this->params['breadcrumbs'][] = ['label' => 'Universities', 'url' => ['index']];
  $this->params['breadcrumbs'][] = $college->name;
  $this->params['breadcrumbs'][] = 'Update Facility';
}

$this->registerCssFile("@web/css/lightgallery.min.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);

$this->registerCssFile("@web/css/video-js.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);

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
        //'allowedPreviewTypes'=> ["image", "video"],
        //'initialPreviewFileType'=>["image", "video"],
        //'allowedPreviewTypes' => ['image','video'],
        'initialPreviewAsData'=>true,
        'allowedFileExtensions' => ['jpg','jpeg','png','gif', 'svg','mp4','avi','mkv','mts','mpv','flv','3gp','avi'],
        //'initialPreview'=> ArrayHelper::getColumn($initialPreviewConfig,'fileurl'),
        //'initialPreviewConfig'=>$initialPreviewConfig
      ],
    ]); ?>

    <?php if (!empty($fileList)) {?>
      <div class="col-md-offset-2 col-md-10">
        <div class="custumbox box box-default ">
          <div  id="lightgallery" class="box-body  box-comments">
            <?php foreach ($fileList as $key => $file) { ?>
              <div class="col-md-4">
                <?php 
                $encID=Yii::$app->myhelper->getEncryptID($file->id);
                if($file->type == 1){
                  $fileUrl = $fBasePath.$file->url;

                  ?>
                  <div class="gallery-file-wrap" data-src="<?= $fileUrl ?>">
                    <img class="img-responsive img-thumbnail" src="<?= $fileUrl  ?>" data-key="<?= Url::to(['university/facility-gallery-delete','id'=>$file->id,'key'=>$encID]) ?>" />
                  </div>
                <?php }else{ 
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

                <?php } ?>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } ?>

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
$this->registerJs('
  $(document).ready(function(){
    function initFunctions(){
      $lg = $("#lightgallery");
      $lg.lightGallery({
        selector:".gallery-file-wrap",
        videojs: true,
        share: false,
        download: false,
        });
        $lg.on("onBeforeOpen.lg",function(event, index, fromTouch, fromThumb){
          console.log(event, index, fromTouch, fromThumb);
          });
        }
        initFunctions();
        
    });
');
?>

  <?php $this->registerJs("".Yii::$app->myhelper->formsubmitedbyajax('w0','../university/index')."");?>
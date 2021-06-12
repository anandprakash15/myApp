<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = $college->name.' '.$fileType.' Gallery';
$this->params['subtitle'] = '<h1>'.ucwords($fileType).' Gallery</h1>';
$this->params['breadcrumbs'][] = ['label' => 'Colleges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $college->name;
$this->params['breadcrumbs'][] = $fileType.' Gallery';

$this->registerCssFile("@web/css/lightgallery.min.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);

$this->registerCssFile("@web/css/video-js.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);

$this->registerJsFile('@web/js/picturefill.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/lightgallery-all.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/jquery.mousewheel.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/video.js',['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerJsFile('@web/js/lg-deletebutton.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<?php 
$this->registerCss("
    .app-title{
     display: none;
 }
 ");
 ?>
<div class="college-index">
	<div class="custumbox col-md-12">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">

				<?php if($type == 1){ ?>
					<li class="active">
						<a>Images</a>
					</li>
					<li>
						<a href="<?= Url::to(['gallery','id'=>$college->id,'type'=>2]) ?>">Videos</a>
					</li>
				<?php }else{ ?>
					<li >
						<a  href="<?= Url::to(['gallery','id'=>$college->id,'type'=>1]) ?>">Images</a>
					</li>
					<li class="active">
						<a>Videos</a>
					</li>
				<?php } ?>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1">
					<div class="box box-default">
						<div class="box-header with-border">
							<i class="fa fa-cloud-upload" aria-hidden="true"></i>
							<h3 class="box-title">Upload File</h3>
							<div class="box-tools">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="box-body" style="">
							<?php
							echo FileInput::widget([
								'name' => 'ufiles[]',
								'options'=>[
									'multiple'=>true,
									'accept' => $fileType.'/*'
								],
								'pluginOptions' => [
									'allowedFileExtensions'=>$allowedFileExtensions,
									'uploadAsync' => false,
									'uploadUrl' => Url::to(['file-upload','id' => $college->id,'type' => $type]),
									'uploadExtraData' => [
										'type' => $type,
									],
									'maxFileCount' => 10
								],
								'pluginEvents'=>[
									'fileloaded'=>"function(){
										$('.file-preview').show();
									}",
									'fileremoved'=>"function(){
										if($(this).fileinput('getFileStack') <= 0 ){
											$('.file-preview').hide();
											$('#uploadstatus').slideUp('slow');
										}
									}",
									"filecleared"=>"function(){
										if($(this).fileinput('getFileStack') <= 0 ){
											$('.file-preview').hide();
											$('#uploadstatus').slideUp('slow');
										}
									}",

									"filebatchuploadsuccess"=>"function(event, data){
										if(data.response.success){
											$('#uploadmessage').html(data.response.success);
											$.pjax.reload({container:'#img-gallery-wrap'}); 
											$('#uploadstatus').slideDown('slow');
										}
									}",

								],
							]);
							?>
							<div id="uploadstatus" style="display: none" class="callout callout-success">
								<h4><i class="icon fa fa-check"></i> Success</h4>
								<p id="uploadmessage"></p>
							</div>
						</div>
					</div>
					<div class="box box-default">
						<div class="box-header with-border">
							<i class="fa <?= ($type==1)?'fa-picture-o':' fa-play-circle' ?>" aria-hidden="true"></i>
							<h3 class="box-title"><?= ($type==1)?'Images':'Videos' ?></h3>
						</div>
						<div class="box-body">
							<?php Pjax::begin([
								'id'=>'img-gallery-wrap'
							]); ?>
							<div id="lightgallery" class="list-unstyled row">
								<?php foreach ($fileList as $key => $file) { ?>
									<div class="col-md-3">
										<?php if($type == 1){
											$fileUrl = $fBasePath.$file->url;
											?>
											<div class="gallery-file-wrap" data-src="<?= $fileUrl ?>">
												<img class="img-responsive img-thumbnail" data-key="<?= Url::to(['delete-gallery-file','id'=>$file->id]) ?>" src="<?= $fileUrl  ?>" />
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
												<img data-key="<?= Url::to(['delete-gallery-file','id'=>$file->id]) ?>"  class="img-responsive img-thumbnail" src="<?= $thumbPath ?>"  />
											</div>

										<?php } ?>
									</div>
								<?php } ?>
							</div>
							<?php Pjax::end(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$this->registerCss("
	.file-preview {
		display:none;
	}");

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
				$(document).on("pjax:success", "#img-gallery-wrap",  function(event){
					initFunctions();
					});
					});
					');
					?>

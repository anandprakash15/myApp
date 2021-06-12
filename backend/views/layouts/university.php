<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\widgets\Menu;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>
<?php
$this->registerCss('
  .content{
    padding-left: 15px;
    padding-right: 15px;
  }
  ')
  ?>
  <body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
    <?php $this->beginBody() ?>

    <div class="wrapper">
      <header class="main-header">
        <!-- Logo -->
        <a href="<?= Url::to(['site/dashboard']) ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>B</b>C</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">Bridge Campus</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- <span class="uc-title">University: <?php //echo @Yii::$app->params['uTitle'] ?></span> -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <?= Html::img('@web/images/avatar5.png',['height'=>"50px",'title'=>'CARE Training','class'=>'user-image'] ) ?>
                  <span class="hidden-xs">Chetan Ambelkar</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <?= Html::img('@web/images/avatar5.png',['title'=>'CARE Training','class'=>'img-circle'] ) ?>


                    <p>
                      <?= \Yii::$app->user->identity->fullname;?>
                      <!-- <small>Member since Nov. 2018</small> -->
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <!-- <li class="user-body">
                    <div class="row">
                      <div class="col-xs-4 text-center">
                        <a href="#">Followers</a>
                      </div>
                      <div class="col-xs-4 text-center">
                        <a href="#">Sales</a>
                      </div>
                      <div class="col-xs-4 text-center">
                        <a href="#">Friends</a>
                      </div>
                    </div>
                  </li> -->
                  <!-- Menu Footer-->
                  <li class="user-footer" style="background-color: #367fa9;">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?= Url::to(['site/logout']) ?>" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>

      <?= $this->render('main-sidebar'); ?>
      
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header col-md-offset-3">
          <h1 class="app-title">
            <?= Html::encode($this->title) ?>
          </h1>
          <?= isset($this->params['subtitle']) ? $this->params['subtitle'] : '';?>
     <!--  <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol> -->
      <?= Breadcrumbs::widget([
        'homeLink' => [ 
          'label' => 'Dashboard',
          'url' => Yii::$app->homeUrl,
          'template' => "<li><i class='fa fa-dashboard'></i> {link}</li>\n",
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
      ]) ?>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
         <div class="box box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">University: <?= @Yii::$app->params['uTitle'] ?></h3>
          </div>
          <div class="box-body no-padding">
            <?php echo Menu::widget([
              'options' => ['class' => 'nav nav-pills nav-stacked','data-widget'=>"tree"],

              'items' => [
                ['label' => '<i class="fa fa-circle-o"></i> View', 'url' => ['/university/view','id'=>@Yii::$app->params['uID']]],
                /*['label' => '<i class="fa fa-circle-o"></i> Update', 'url' => ['/university/update','id'=>@Yii::$app->params['uID']]],*/
                ['label' => '<i class="fa fa-circle-o"></i> Courses', 'url' => ['/university/courses','id'=>@Yii::$app->params['uID']]],
                ['label' => '<i class="fa fa-circle-o"></i> Gallery', 'url' => ['/university/gallery','id'=>@Yii::$app->params['uID'],'type'=>1]],
                ['label' => '<i class="fa fa-circle-o"></i> Facilities', 'url' => ['/university/facility','id'=>@Yii::$app->params['uID']]],
                ['label' => '<i class="fa fa-circle-o"></i> Review', 'url' => ['/university/review','id'=>@Yii::$app->params['uID']]],
                ['label' => '<i class="fa fa-circle-o"></i> Advertise Materials', 'url' => ['/university/advertise-materials','id'=>@Yii::$app->params['uID']]],

              ],
              'submenuTemplate' => "\n<ul class='treeview-menu'>\n{items}\n</ul>\n",
        'encodeLabels' => false, //allows you to use html in labels
        'activateParents' => true,
      ]);

      ?>
    </div>
    <!-- /.box-body -->
  </div>
</div>
<div class="col-md-9">
  <?= $content ?> 

</div>
</div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?= $this->render('footer') ?>

<div class="control-sidebar-bg"></div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

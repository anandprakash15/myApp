<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'Bridge Campus';
?>
<div class="site-dashboard">
  <div>
    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?= $data['college'];?> </h3>

          <p>Total Colleges</p>
        </div>
        <div class="icon">
          <i class="fa fa-building"></i>
        </div>
        <a href="<?= Url::to(['college/index']) ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?= $data['university'];?></h3>

          <p>Total Universities</p>
        </div>
        <div class="icon">
          <i class="fa fa-university"></i>
        </div>
        <a href="<?= Url::to(['university/index']) ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?= $data['exam'];?></h3>

          <p>Total Exams</p>
        </div>
        <div class="icon">
          <i class="fa fa-pencil-square-o"></i>
        </div>
        <a href="<?= Url::to(['exam/index']) ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?= $data['courses'];?></h3>

          <p>Total Courses</p>
        </div>
        <div class="icon">
          <i class="fa fa-book"></i>
        </div>
        <a href="<?= Url::to(['courses/index']) ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-maroon">
        <div class="inner">
          <h3><?= $data['advertise'];?></h3>

          <p>Total Advertisements</p>
        </div>
        <div class="icon">
          <i class="fa fa-tasks"></i>
        </div>
        <a href="<?= Url::to(['advertise/index']) ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
      <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-purple">
        <div class="inner">
          <h3><?= $data['users'];?></h3>

          <p>Users</p>
        </div>
        <div class="icon">
          <i class="fa fa-user"></i>
        </div>
        <a href="<?= Url::to(['user/index']) ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
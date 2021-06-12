<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\CollegeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="college-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'cityID') ?>

    <?php // echo $form->field($model, 'stateID') ?>

    <?php // echo $form->field($model, 'countryID') ?>

    <?php // echo $form->field($model, 'taluka') ?>

    <?php // echo $form->field($model, 'district') ?>

    <?php // echo $form->field($model, 'pincode') ?>

    <?php // echo $form->field($model, 'contact') ?>

    <?php // echo $form->field($model, 'fax') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'websiteurl') ?>

    <?php // echo $form->field($model, 'establish_year') ?>

    <?php // echo $form->field($model, 'approved_by') ?>

    <?php // echo $form->field($model, 'accredited_by') ?>

    <?php // echo $form->field($model, 'affiliate_to') ?>

    <?php // echo $form->field($model, 'rating') ?>

    <?php // echo $form->field($model, 'about') ?>

    <?php // echo $form->field($model, 'vission') ?>

    <?php // echo $form->field($model, 'mission') ?>

    <?php // echo $form->field($model, 'logourl') ?>

    <?php // echo $form->field($model, 'createdDate') ?>

    <?php // echo $form->field($model, 'updatedDate') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'createdBy') ?>

    <?php // echo $form->field($model, 'updatedBy') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

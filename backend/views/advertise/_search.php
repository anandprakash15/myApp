<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\AdvertiseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="advertise-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'coll_univID') ?>

    <?= $form->field($model, 'college_university_advpurposeID') ?>

    <?= $form->field($model, 'programID') ?>

    <?php // echo $form->field($model, 'courseID') ?>

    <?php // echo $form->field($model, 'fromDate') ?>

    <?php // echo $form->field($model, 'toDate') ?>

    <?php // echo $form->field($model, 'cityID') ?>

    <?php // echo $form->field($model, 'stateID') ?>

    <?php // echo $form->field($model, 'countryID') ?>

    <?php // echo $form->field($model, 'description') ?>

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

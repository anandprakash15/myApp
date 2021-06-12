<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\FrontendSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="frontend-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'about') ?>

    <?= $form->field($model, 'about_status') ?>

    <?= $form->field($model, 'privacy') ?>

    <?= $form->field($model, 'privacy_status') ?>

    <?php // echo $form->field($model, 'term_condition') ?>

    <?php // echo $form->field($model, 'term_condition_status') ?>

    <?php // echo $form->field($model, 'createdBy') ?>

    <?php // echo $form->field($model, 'updatedBy') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'updated_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

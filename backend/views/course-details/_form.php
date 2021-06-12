<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CourseDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-details-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'duration')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fees')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uccID')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'updatedDate')->textInput() ?>

    <?= $form->field($model, 'updatedBy')->textInput() ?>

    <?= $form->field($model, 'createdBy')->textInput() ?>

    <?= $form->field($model, 'createdDate')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

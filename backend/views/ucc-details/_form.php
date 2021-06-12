<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UccDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ucc-details-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'uccID')->textInput() ?>

    <?= $form->field($model, 'fees')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'duration')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'approved_by')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'accredited_by')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'createdBy')->textInput() ?>

    <?= $form->field($model, 'updatedBy')->textInput() ?>

    <?= $form->field($model, 'createdDate')->textInput() ?>

    <?= $form->field($model, 'updatedDate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

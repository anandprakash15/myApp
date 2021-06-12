<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Review */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="review-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'coll_univID')->textInput() ?>

    <?= $form->field($model, 'courseID')->textInput() ?>

    <?= $form->field($model, 'placement_star')->textInput() ?>

    <?= $form->field($model, 'placement_review')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'infrastructure_star')->textInput() ?>

    <?= $form->field($model, 'infrastructure_review')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fcc_star')->textInput() ?>

    <?= $form->field($model, 'fcc_review')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ccl_star')->textInput() ?>

    <?= $form->field($model, 'cct_review')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'wtd_star')->textInput() ?>

    <?= $form->field($model, 'wtd_review')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'other_star')->textInput() ?>

    <?= $form->field($model, 'other_review')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'createdDate')->textInput() ?>

    <?= $form->field($model, 'updatedDate')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'createdBy')->textInput() ?>

    <?= $form->field($model, 'updatedBy')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

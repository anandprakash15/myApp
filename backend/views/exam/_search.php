<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\ExamSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="exam-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'programID') ?>

    <?= $form->field($model, 'courseID') ?>

    <?= $form->field($model, 'exam_name') ?>

    <?= $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'short_name') ?>

    <?php // echo $form->field($model, 'exam_course_level') ?>

    <?php // echo $form->field($model, 'overview') ?>

    <?php // echo $form->field($model, 'registration_end_date') ?>

    <?php // echo $form->field($model, 'registration_extended_date_from') ?>

    <?php // echo $form->field($model, 'registration_extended_date_to') ?>

    <?php // echo $form->field($model, 'admit_card_download_start_date') ?>

    <?php // echo $form->field($model, 'admit_card_download_end_date') ?>

    <?php // echo $form->field($model, 'online_exam_date') ?>

    <?php // echo $form->field($model, 'paper_based_test_date') ?>

    <?php // echo $form->field($model, 'result_date') ?>

    <?php // echo $form->field($model, 'result_overview') ?>

    <?php // echo $form->field($model, 'cut_off') ?>

    <?php // echo $form->field($model, 'syllabus') ?>

    <?php // echo $form->field($model, 'exam_pattern') ?>

    <?php // echo $form->field($model, 'exam_duration') ?>

    <?php // echo $form->field($model, 'no_of_questions') ?>

    <?php // echo $form->field($model, 'total_marks') ?>

    <?php // echo $form->field($model, 'language_of_paper') ?>

    <?php // echo $form->field($model, 'marks_per_question') ?>

    <?php // echo $form->field($model, 'negative_marks_per_question') ?>

    <?php // echo $form->field($model, 'do_dont_during_the_exam') ?>

    <?php // echo $form->field($model, 'exam_registration_website') ?>

    <?php // echo $form->field($model, 'couducting_authority') ?>

    <?php // echo $form->field($model, 'exam_centres') ?>

    <?php // echo $form->field($model, 'exam_helpline_nos') ?>

    <?php // echo $form->field($model, 'number_of_exam_cities') ?>

    <?php // echo $form->field($model, 'exam_books_guide') ?>

    <?php // echo $form->field($model, 'question_papers') ?>

    <?php // echo $form->field($model, 'exam_FAQ') ?>

    <?php // echo $form->field($model, 'createdDate') ?>

    <?php // echo $form->field($model, 'updatedDate') ?>

    <?php // echo $form->field($model, 'createdBy') ?>

    <?php // echo $form->field($model, 'updatedBy') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

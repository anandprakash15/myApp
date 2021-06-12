<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Exam */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Exams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="exam-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'programID',
            'courseID',
            'exam_name:ntext',
            'type:ntext',
            'short_name:ntext',
            'exam_course_level',
            'overview:ntext',
            'registration_end_date:ntext',
            'registration_extended_date_from:ntext',
            'registration_extended_date_to:ntext',
            'admit_card_download_start_date:ntext',
            'admit_card_download_end_date:ntext',
            'online_exam_date:ntext',
            'paper_based_test_date:ntext',
            'result_date:ntext',
            'result_overview:ntext',
            'cut_off:ntext',
            'syllabus:ntext',
            'exam_pattern:ntext',
            'exam_duration:ntext',
            'no_of_questions:ntext',
            'total_marks:ntext',
            'language_of_paper:ntext',
            'marks_per_question:ntext',
            'negative_marks_per_question:ntext',
            'do_dont_during_the_exam:ntext',
            'exam_registration_website:ntext',
            'couducting_authority:ntext',
            'exam_centres:ntext',
            'exam_helpline_nos:ntext',
            'number_of_exam_cities:ntext',
            'exam_books_guide:ntext',
            'question_papers:ntext',
            'exam_FAQ:ntext',
            'createdDate',
            'updatedDate',
            'createdBy',
            'updatedBy',
        ],
    ]) ?>

</div>

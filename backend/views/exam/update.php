<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Exam */

$this->title = 'Update Exam: ' . $model->exam_name;
$this->params['breadcrumbs'][] = ['label' => 'Exams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->exam_name;
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="exam-update">

    <?= $this->render('_form', [
        'model' => $model,
        'program' => $program,
            'course' => $course,
    ]) ?>

</div>

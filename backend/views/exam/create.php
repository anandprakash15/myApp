<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Exam */

$this->title = 'Create Exam';
$this->params['breadcrumbs'][] = ['label' => 'Exams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exam-create">
    <?= $this->render('_form', [
        'model' => $model,
        'program' => $program,
            'course' => $course,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Courses */

$this->title = 'Update Courses: '.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="courses-update">
    <?= $this->render('_form', [
        'model' => $model,
        'specialization'=> $specialization,
		'program' => $program,
		'program_categoryID' => $program_categoryID,
		'exams' => $exams,
    ]) ?>

</div>

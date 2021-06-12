<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Courses */

$this->title = 'Create Courses';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courses-create">
	
    <?= $this->render('_form', [
        'model' => $model,
        'specialization'=> $specialization,
		'program' => $program,
		'program_categoryID' => $program_categoryID,
		'exams' => $exams,

    ]) ?>

</div>

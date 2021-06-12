<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CourseDetails */

$this->title = 'Create Course Details';
$this->params['breadcrumbs'][] = ['label' => 'Course Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

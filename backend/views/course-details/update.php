<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CourseDetails */

$this->title = 'Update Course Details: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Course Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="course-details-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

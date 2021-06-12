<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ExamCategory */

$this->title = 'Update Exam Category';
$this->params['breadcrumbs'][] = ['label' => 'Exam Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="exam-category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

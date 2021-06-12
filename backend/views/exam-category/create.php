<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ExamCategory */

$this->title = 'Create Exam Category';
$this->params['breadcrumbs'][] = ['label' => 'Exam Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exam-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

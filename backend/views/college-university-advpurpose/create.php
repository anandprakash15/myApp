<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CollegeUniversityAdvpurpose */

$this->title = 'Create College University Advpurpose';
$this->params['breadcrumbs'][] = ['label' => 'College University Advpurposes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="college-university-advpurpose-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

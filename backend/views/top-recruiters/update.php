<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TopRecreuitors */

$this->title = 'Update Top Recruiters: ' . $model->company;
$this->params['breadcrumbs'][] = ['label' => 'Top Recruiters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->company, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="top-recruiters-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

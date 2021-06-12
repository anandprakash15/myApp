<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TopRecreuitors */

$this->title = 'Create Top Recruiters';
$this->params['breadcrumbs'][] = ['label' => 'Top Recruiters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="top-recruiters-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

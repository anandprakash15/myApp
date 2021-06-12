<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\College */

$this->title = 'Update College';
$this->params['breadcrumbs'][] = ['label' => 'Colleges', 'url' => ['index']];
$this->params['breadcrumbs'][] =  $model->name;
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="college-update">
    <?= $this->render('_form', [
        'model' => $model,
        'approved_by' => $approved_by,
        'accredited_by' => $accredited_by,
        'affiliate_to'=>$affiliate_to,
    ]) ?>

</div>

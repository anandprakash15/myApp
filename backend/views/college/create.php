<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\College */

$this->title = 'Create College';
$this->params['breadcrumbs'][] = ['label' => 'Colleges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="college-create">
    <?= $this->render('_form', [
        'model' => $model,
        'approved_by' => $approved_by,
        'accredited_by' => $approved_by,
        'affiliate_to'=>$affiliate_to,
    ]) ?>

</div>

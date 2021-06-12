<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Approved */

$this->title = 'Update Approved by Government: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Approved by Government', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="approved-by-government-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

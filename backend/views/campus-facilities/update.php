<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CampusFacilities */

$this->title = 'Update Campus Facilities: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Campus Facilities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="campus-facilities-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

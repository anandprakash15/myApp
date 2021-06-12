<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CampusFacilities */

$this->title = 'Create Campus Facilities';
$this->params['breadcrumbs'][] = ['label' => 'Campus Facilities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campus-facilities-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

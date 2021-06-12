<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Specialization */

$this->title = 'Update Specialization';
$this->params['breadcrumbs'][] = ['label' => 'Specializations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="specialization-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

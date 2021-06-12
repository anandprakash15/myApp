<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Specialization */

$this->title = 'Create Specialization';
$this->params['breadcrumbs'][] = ['label' => 'Specializations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="specialization-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

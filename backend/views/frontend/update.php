<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Frontend */

$this->title = 'Update Frontend';
$this->params['breadcrumbs'][] = ['label' => 'Frontends', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="frontend-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

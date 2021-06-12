<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UccDetails */

$this->title = 'Update Ucc Details: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ucc Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ucc-details-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

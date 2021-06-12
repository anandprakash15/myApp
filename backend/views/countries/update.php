<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Countries */

$this->title = 'Update Countries: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Countries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="countries-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

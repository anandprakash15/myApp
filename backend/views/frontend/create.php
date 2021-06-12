<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Frontend */

$this->title = 'Create Frontend';
$this->params['breadcrumbs'][] = ['label' => 'Frontends', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="frontend-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Approved */

$this->title = 'Create Approved by Government';
$this->params['breadcrumbs'][] = ['label' => 'Approved by Government', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="approved-government-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

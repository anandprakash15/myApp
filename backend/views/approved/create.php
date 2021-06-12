<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Approved */

$this->title = 'Create Approved by';
$this->params['breadcrumbs'][] = ['label' => 'Approved by', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="approved-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

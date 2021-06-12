<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Facility */

$this->title = 'Create Facility';
$this->params['breadcrumbs'][] = ['label' => 'Facilities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="facility-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

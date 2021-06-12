<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UccDetails */

$this->title = 'Create Ucc Details';
$this->params['breadcrumbs'][] = ['label' => 'Ucc Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ucc-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

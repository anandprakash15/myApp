<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Accredited */

$this->title = 'Update Accreditation: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Accreditations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="accreditation-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

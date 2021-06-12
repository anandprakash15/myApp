<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\NaacAccreditation */

$this->title = 'Update NAAC Accreditation ';
$this->params['breadcrumbs'][] = ['label' => 'NAAC Accreditations', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="naac-accreditation-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

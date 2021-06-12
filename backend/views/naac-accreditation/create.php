<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\NaacAccreditation */

$this->title = 'Create NAAC Accreditation';
$this->params['breadcrumbs'][] = ['label' => 'NAAC Accreditations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="naac-accreditation-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

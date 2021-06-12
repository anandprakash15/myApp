<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Accredited */

$this->title = 'Create Accreditation';
$this->params['breadcrumbs'][] = ['label' => 'Accreditations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accreditation-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

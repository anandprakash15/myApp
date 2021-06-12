<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\University */

$this->title = 'Create University';
$this->params['breadcrumbs'][] = ['label' => 'Universities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="university-create">

    <?= $this->render('_form', [
        'model' => $model,
        'approved_by'=>$approved_by,
        'accredited_by' => $accredited_by,
        'affiliate_to' => $affiliate_to,
        'approvedGovernment' => $approvedGovernment,
        'universityBrochures'=>$universityBrochures,
        'brochureFilePreview'=>$brochureFilePreview
    ]) ?>

</div>

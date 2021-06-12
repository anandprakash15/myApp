<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\University */

$this->title = 'Update University: '.$model->name;
$this->params['subtitle'] = '<h1>Update University</h1>';;
$this->params['breadcrumbs'][] = ['label' => 'Universities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="university-update">
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
<?php 
$this->registerCss("
    .app-title{
       display: none;
   }
   ");
   ?>
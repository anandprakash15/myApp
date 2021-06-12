<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Affiliations */

$this->title = 'Create Affiliation';
$this->params['breadcrumbs'][] = ['label' => 'Affiliations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="affiliation-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

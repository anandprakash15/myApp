<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CollegeGallery */

$this->title = 'Create College Gallery';
$this->params['breadcrumbs'][] = ['label' => 'College Galleries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="college-gallery-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

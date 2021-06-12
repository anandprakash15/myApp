<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\NewsArtical */

$this->title = 'Update News Artical';
$this->params['breadcrumbs'][] = ['label' => 'News Articals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="news-artical-update">

    <?= $this->render('_form', [
        'model' => $model,
        'program' => $program,
        'coll_univ_examid' => $coll_univ_examid,
    ]) ?>

</div>

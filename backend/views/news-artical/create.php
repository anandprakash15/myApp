<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\NewsArtical */

$this->title = 'Create News Artical';
$this->params['breadcrumbs'][] = ['label' => 'News Articals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-artical-create">

    <?= $this->render('_form', [
        'model' => $model,
        'program' => [],
        'coll_univ_examid' => $coll_univ_examid,

    ]) ?>

</div>

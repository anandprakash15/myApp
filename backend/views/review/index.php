<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ReviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reviews';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Review', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'type',
            'coll_univID',
            'courseID',
            'placement_star',
            //'placement_review:ntext',
            //'infrastructure_star',
            //'infrastructure_review:ntext',
            //'fcc_star',
            //'fcc_review:ntext',
            //'ccl_star',
            //'cct_review:ntext',
            //'wtd_star',
            //'wtd_review:ntext',
            //'other_star',
            //'other_review:ntext',
            //'createdDate',
            //'updatedDate',
            //'status',
            //'createdBy',
            //'updatedBy',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

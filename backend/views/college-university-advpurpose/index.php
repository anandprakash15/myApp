<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CollegeUniversityAdvpurposeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'College University Advpurposes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="college-university-advpurpose-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create College University Advpurpose', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'type',
            'coll_univID',
            'gtype',
            'url:ntext',
            //'createdDate',
            //'updatedDate',
            //'status',
            //'createdBy',
            //'updatedBy',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

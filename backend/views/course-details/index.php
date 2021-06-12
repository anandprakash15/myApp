<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CourseDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Course Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-details-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Course Details', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'duration:ntext',
            'fees',
            'uccID',
            'description:ntext',
            //'updatedDate',
            //'updatedBy',
            //'createdBy',
            //'createdDate',
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

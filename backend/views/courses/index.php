<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CoursesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Courses';
$this->params['subtitle'] = '<h1>Courses '.Yii::$app->myhelper->getCreatenew($roleid = array(1),'','Add').'</h1>';
$this->params['breadcrumbs'][] = $this->title;
$status = Yii::$app->myhelper->getActiveInactive();
$fullparttime = Yii::$app->myhelper->getFullPartTime();

echo Yii::$app->message->display();
?>
<div class="courses-index">
    <div class="custumbox box box-info">
     <div class="box-body">
        <?= GridView::widget([
            'striped'=>false,
            'hover'=>true,
            'panel'=>['type'=>'default', 'heading'=>'Course List','after'=>false],
            'toolbar'=> [
                '{export}',
                '{toggleData}',
            ],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'contentOptions' => ['style' => 'width:36%;'],
                    'attribute' => 'name',
                ],
                [
                    'contentOptions' => ['style' => 'width:12%;'],
                    'attribute' => 'short_name',
                ],
                [
                    'label'=>'Program',
                    'contentOptions' => ['style' => 'width:12%;'],
                    'attribute' => 'program',
                    'value' => function($model){
                        return $model['program']['name'];
                    }
                ],

                [
                    'attribute' => 'full_part_time',
                    'filter' => $fullparttime,
                    'value' => function($model)use($fullparttime){
                        return $fullparttime[$model['full_part_time']];
                    }

                ],

                [
                    'attribute' => 'status',
                    'filter' => $status,
                    'value' => function($model)use($status){
                        return $status[$model['status']];
                    }

                ],
                [
                  'class' => 'yii\grid\ActionColumn',
                  'template' => '{specialization}',/*{top_recruiters}*/
                  'buttons' => [
                    'specialization' => function ($url, $model) {
                        return Html::a(Yii::t('app', 'Add Specializations'), Url::to(['add-specializations','id'=>$model->id]), [
                            'title' => Yii::t('app', 'Add Specializations'),
                            'class'=>'btn btn-primary btn btn-xs'
                        ]);
                    },
                    /*'top_recruiters' => function ($url, $model) {
                        return Html::a(Yii::t('app', 'Add Recruiters'), Url::to(['add-recruiters','id'=>$model->id]), [
                            'title' => Yii::t('app', 'Add Recruiters'),
                            'class'=>'btn btn-success btn btn-xs'
                        ]);
                    }*/
                ],
            ],

        ],
    ]); ?>
</div>
</div>
</div>
<?php 
$this->registerCss("
    .app-title{
     display: none;
 }
 ");
 ?>
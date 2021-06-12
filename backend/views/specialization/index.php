<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SpecializationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Specializations';
$this->params['subtitle'] = '<h1>Specializations '.Yii::$app->myhelper->getCreatenew($roleid = array(1),'','Add').'</h1>';
$this->params['breadcrumbs'][] = $this->title;
$status = Yii::$app->myhelper->getActiveInactive();

echo Yii::$app->message->display();
?>

<div class="specialization-index">
    <div class="custumbox box box-info">
        <div class="box-body">
            <?= GridView::widget([
                'striped'=>false,
                'hover'=>true,
                'panel'=>['type'=>'default', 'heading'=>'Specializations List','after'=>false],
                'toolbar'=> [
                    '{export}',
                    '{toggleData}',
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'kartik\grid\SerialColumn'],

                    'name',
                    [
                        'attribute' => 'status',
                        'filter' => $status,
                        'value' => function($model)use($status){
                            return $status[$model['status']];
                        }
                    ],
                    [
                      'class' => 'yii\grid\ActionColumn',
                      'template' => '{top_recruiters}',
                      'contentOptions' => ['style' => 'width:15%;'],
                      'buttons' => [
                        'top_recruiters' => function ($url, $model) {
                            return Html::a(Yii::t('app', 'Add Recruiters'), Url::to(['add-recruiters','id'=>$model->id]), [
                                'title' => Yii::t('app', 'Add Recruiters'),
                                'class'=>'btn btn-primary btn btn-xs'
                            ]);
                        }
                    ],
                ],
            ],

            'exportConfig'=> [
                GridView::CSV=>[
                    'label' => 'CSV',
                ],
                GridView::EXCEL=>[
                    'label' => 'Excel',
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


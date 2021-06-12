<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SpecializationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'News / Articals';
$this->params['subtitle'] = '<h1>News / Articals '.Yii::$app->myhelper->getCreatenew($roleid = array(1),'','Add').'</h1>';
$this->params['breadcrumbs'][] = $this->title;
$status = Yii::$app->myhelper->getActiveInactive();
$national_international = Yii::$app->myhelper->getNationalInternational();
$natype = Yii::$app->myhelper->getNewsArtical();
echo Yii::$app->message->display();
?>

<div class="specialization-index">
    <div class="custumbox box box-info">
        <div class="box-body">
            <?= GridView::widget([
                'striped'=>false,
                'hover'=>true,
                'panel'=>['type'=>'default', 'heading'=>'News / Articals List','after'=>false],
                'toolbar'=> [
                    '{export}',
                    '{toggleData}',
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'kartik\grid\SerialColumn'],

                    'title',
                    [
                        'attribute' => 'startDate',
                        'value' => function($model){
                            return date('d-m-Y',strtotime($model['startDate']));
                        }
                    ],

                    [
                        'attribute' => 'endDate',
                        'value' => function($model){
                            return date('d-m-Y',strtotime($model['endDate']));
                        }
                    ],

                    
                    [
                        'attribute' => 'national_international',
                        'filter' => $national_international,
                        'value' => function($model)use($national_international){
                            return $national_international[$model['national_international']];
                        }
                    ],

                    [
                        'attribute' => 'natype',
                        'filter' => $natype,
                        'value' => function($model)use($natype){
                            return $natype[$model['natype']];
                        }
                    ],

                    [
                        'attribute' => 'status',
                        'filter' => $status,
                        'value' => function($model)use($status){
                            return $status[$model['status']];
                        }
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


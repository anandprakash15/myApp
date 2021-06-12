<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SpecializationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Advertises';
$this->params['subtitle'] = '<h1>Advertise '.Yii::$app->myhelper->getCreatenew($roleid = array(1),'','Add').'</h1>';
$this->params['breadcrumbs'][] = $this->title;
$status = Yii::$app->myhelper->getActiveInactive();
$type = Yii::$app->myhelper->getAdvertisetype();
echo Yii::$app->message->display();
?>

<div class="specialization-index">
    <div class="custumbox box box-info">
        <div class="box-body">
            <?= GridView::widget([
                'striped'=>false,
                'hover'=>true,
                'panel'=>['type'=>'default', 'heading'=>'Advertise List','after'=>false],
                'toolbar'=> [
                    '{export}',
                    '{toggleData}',
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'kartik\grid\SerialColumn'],

                    [
                        'attribute' => 'status',
                        'filter' => $type,
                        'value' => function($model)use($type){
                            return $type[$model['type']];
                        }
                    ],

                    [
                        'attribute' => 'coll_univID',
                        'filter' => false,
                        'value' => function($model){
                            if($model['type'] == 1){
                                return $model->university->name;
                            }else{
                                return $model->college->name;
                            }
                            
                        }
                    ],

                    [
                        'attribute' => 'fromDate',
                        'filter' => false,
                        'value' => function($model)use($status){
                            return date('d-m-Y',strtotime($model['fromDate']));
                        }
                    ],
                    [
                        'attribute' => 'toDate',
                        'filter' => false,
                        'value' => function($model)use($status){
                            return date('d-m-Y',strtotime($model['toDate']));
                        }
                    ],

                    [
                        'attribute' => 'status',
                        'filter' => $type,
                        'value' => function($model)use($type){
                            return $type[$model['type']];
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


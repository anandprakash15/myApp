<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\NaacAccreditationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'NAAC Accreditations';
$this->params['subtitle'] = '<h1>NAAC Accreditations '.Yii::$app->myhelper->getCreatenew($roleid = array(1),'','Add').'</h1>';
$this->params['breadcrumbs'][] = $this->title;
$status = Yii::$app->myhelper->getActiveInactive();
$performanceDescriptor = Yii::$app->myhelper->getPerformanceDescriptor();

echo Yii::$app->message->display();
?>
<div class="naac-accreditation-index">
    <div class="custumbox box box-info">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'institutional_cgpa',
                    'grade',
                    [
                        'attribute' => 'performance_descriptor',
                        'filter' => $performanceDescriptor,
                        'value' => function($model)use($performanceDescriptor){
                            return isset($performanceDescriptor[$model['performance_descriptor']])?$performanceDescriptor[$model['performance_descriptor']]:'';
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
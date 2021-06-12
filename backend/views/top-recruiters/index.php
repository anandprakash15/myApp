<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SpecializationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Top Recruiters';
$this->params['subtitle'] = '<h1>Top Recruiters '.Yii::$app->myhelper->getCreatenew($roleid = array(1),'','Add').'</h1>';
$this->params['breadcrumbs'][] = $this->title;
$status = Yii::$app->myhelper->getActiveInactive();
$sectors = Yii::$app->myhelper->getIndustrySector();

echo Yii::$app->message->display();
?>
<div class="top-recruiters-index">
    <div class="custumbox box box-info">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    [
                        'attribute' => 'industry_sectorID',
                        'filter' => $sectors,
                        'value' => function($model)use($sectors){
                            return $model->industrySector->name;
                        }
                    ],
                    'company',
                    'short_name',
                    //'logo',
                    [
                        'attribute' => 'status',
                        'filter' => $status,
                        'value' => function($model)use($status){
                            return $status[$model['status']];
                        }
                    ],

                    //['class' => 'yii\grid\ActionColumn'],
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

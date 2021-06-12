<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UniversitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Universities';
$this->params['subtitle'] = '<h1>Universities '.Yii::$app->myhelper->getCreatenew($roleid = array(1),'','Add').'</h1>';
$this->params['breadcrumbs'][] = $this->title;
$status = Yii::$app->myhelper->getActiveInactive();

echo Yii::$app->message->display();
?>
<div class="university-index">
    <div class="custumbox box box-info">
       <div class="box-body">
        <?= GridView::widget([
            'striped'=>false,
            'hover'=>true,
            'panel'=>['type'=>'default', 'heading'=>'University List','after'=>false],
            'toolbar'=> [
                '{export}',
                '{toggleData}',
            ],
            'rowOptions' => function ($model, $key, $index, $grid) {
                $url = Url::to(['view','id'=> $model['id']]);
                return ['onclick' => 'location.href="'.$url.'"'];
            },
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'contentOptions' => ['style' => 'width:45%;'],
                    'attribute' => 'name'
                ],
                [
                    'label'=>'Short Name',
                    'contentOptions' => ['style' => 'width:10%;'],
                    'attribute' => 'short_name',
                ],
                [
                    'label'=>'Code',
                    'contentOptions' => ['style' => 'width:15%;'],
                    'attribute' => 'code',
                    'value' => function($model){
                        return  Yii::$app->myhelper->getUniversityCode($model->code);
                    }
                ],
                [
                    'label'=>'City',
                    'contentOptions' => ['style' => 'width:15%;'],
                    'attribute' => 'city_name',
                    'value' => function($model){
                        return  isset($model->city->name)?$model->city->name:'';
                    }
                ],
                [
                    'label'=>'State',
                    'contentOptions' => ['style' => 'width:15%;'],
                    'attribute' => 'state_name',
                    'value' => function($model){
                        return  isset($model->state->name)?$model->state->name:'';
                    }
                ]
                /*[
                    'label'=>'City',
                    'contentOptions' => ['style' => 'width:45%;'],
                    'attribute' => 'cityname',
                    'value' => function($model){
                        return  $model->city->name;
                    }
                ],*/
               
            //'stateID',
            //'countryID',
            //'taluka',
            //'district',
            //'pincode',
            //'contact',
            //'fax',
            //'email:email',
            //'websiteurl',
            //'establish_year',
            //'approved_by:ntext',
            //'accredited_by:ntext',
            //'grade',
            //'about:ntext',
            //'brochureurl',
            //'logourl',
            //'createdDate',
            //'updatedDate',
            //'status',
            //'createdBy',
            //'updatedBy',

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
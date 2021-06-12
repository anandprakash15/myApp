<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use softark\duallistbox\DualListbox;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UniversitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reviews: '.$university->name;
$this->params['subtitle'] = '<h1>Reviews</h1>';
$this->params['breadcrumbs'][] = ['label' => 'Colleges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $university->name;
$this->params['breadcrumbs'][] = 'Reviews';
$status = Yii::$app->myhelper->getActiveInactive();
$ftype = Yii::$app->myhelper->getFacility();

echo Yii::$app->message->display();
?>

<div class="university-review-index">
	<div class="custumbox box box-info">
		<div class="box-body">
			<?= GridView::widget([
                'striped'=>false,
                'hover'=>true,
                'panel'=>['type'=>'default', 'heading'=>$this->title,'after'=>false],
                'toolbar'=> [
                    '{export}',
                    '{toggleData}',
                ],
                'rowOptions' => function ($model, $key, $index, $grid)use($university) {
                    $url = Url::to(['review-details','id'=> $university->id,'rid'=>$model->id]);
                    return ['onclick' => 'location.href="'.$url.'"'];
                },
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'fullname',
                        'value' => function($model){
                            return $model->createdBy0->fullname;
                        }
                    ],
                    [
                        'attribute' => 'createdDate',
                        'value' => function($model){
                            return date('d-m-Y H:m A');
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
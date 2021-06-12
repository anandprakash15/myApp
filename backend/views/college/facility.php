<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use softark\duallistbox\DualListbox;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UniversitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Facilities: '.$college->name;
$this->params['subtitle'] = '<h1>Facilities <a class="btn btn-success btn-xs" href="'.Url::to(['facility-details','id'=>$college->id]).'">Add</a></h1>';

$this->params['breadcrumbs'][] = ['label' => 'Colleges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $college->name;
$this->params['breadcrumbs'][] = 'Facilities';
$status = Yii::$app->myhelper->getActiveInactive();
$ftype = Yii::$app->myhelper->getFacility();

echo Yii::$app->message->display();
?>

<div class="college-index">
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
                'rowOptions' => function ($model, $key, $index, $grid)use($college) {
                    $url = Url::to(['facility-details','id'=> $college->id,'fid'=>$model->id]);
                    return ['onclick' => 'location.href="'.$url.'"'];
                },
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'ftype',
                        'filter' => $ftype,
                        'value' => function($model)use($ftype){
                            return (isset($ftype[$model['ftype']])?$ftype[$model['ftype']]:"");
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
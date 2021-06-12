<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use softark\duallistbox\DualListbox;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UniversitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $college->name.' College Courses';
$this->params['subtitle'] = '<h1>Courses <a class="btn btn-success btn-xs" href="'.Url::to(["college/course-details",'id'=>$college->id]).'">Add</a></h1>';

$this->params['breadcrumbs'][] = ['label' => 'Colleges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $college->name;
$this->params['breadcrumbs'][] = 'Courses';

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
                'rowOptions' => function ($model, $key, $index, $grid) {
                   /* $url = Url::to(['update','id'=> $model['id']]);
                    return ['onclick' => 'location.href="'.$url.'"'];*/
                },
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                       'label'=>'Name',
                       'contentOptions' => ['style' => 'width:50%;'],
                       'attribute' => 'cname',
                       'value' => function($model){
                        return $model['course']['name'];
                    }
                ],
                [
                	'label'=>'Program',
                	'contentOptions' => ['style' => 'width:25%;'],
                    'attribute' => 'program',
                    'value' => function($model){
                        return $model['course']['program']['name'];
                    }
                ],

                [
                    'class' => 'kartik\grid\ActionColumn',
                    'width'=>'30%',
                    'buttons' => [
                        'info' => function ($url, $model, $key)use($college) {
                            $btn = Html::button("Details",['class'=>'btn btn-success btn btn-xs connect_icon']);
                            return Html::a($btn,["college/course-details", 'id'=>$college->id,'uccID' => $model->id],['title'=>'Info']);

                        },
                        'specializations' => function ($url, $model, $key) {
                            $btn = Html::button("Add Specializations",['class'=>'btn btn-primary btn btn-xs connect_icon']);
                            return Html::a($btn,["college/add-specializations", 'id' => $model->id],['title'=>'Info']);
                        },
                    ],
                    'template' => '{info} {specializations}'
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
<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UniversitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $university->name.' University Courses';
$this->params['subtitle'] = '<h1>Courses <a class="btn btn-success btn-xs" href="'.Url::to(['add-courses','id'=>$university->id]).'">Add</a></h1>';

$this->params['breadcrumbs'][] = ['label' => 'Universities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $university->name;
$this->params['breadcrumbs'][] = 'Courses';

echo Yii::$app->message->display();
?>

<div class="university-index">
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
                    $url = Url::to(["university/course-details", 'id' => $model->id]);
                    return ['onclick' => 'location.href="'.$url.'"'];
                },
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                     'label'=>'Course Name',
                     'contentOptions' => ['style' => 'width:50%;'],
                     'attribute' => 'course_name',
                     'value' => function($model){
                        return $model['course']['name'];
                    }
                ],
                [
                	'label'=>'Program',
                	'contentOptions' => ['style' => 'width:25%;'],
                    'attribute' => 'program_name',
                    'value' => function($model){
                        return $model['course']['program']['name'];
                    }
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{specializations} {exams}',
                    'buttons' => [
                        'specializations' => function ($url, $model, $key) {
                            $btn = Html::button("Add Specializations",['class'=>'btn btn-primary btn btn-xs connect_icon']);
                            return Html::a($btn,["university/add-specializations", 'id' => $model->id],['title'=>'Add Specializations']);
                        },
                        'exams' => function ($url, $model, $key) {
                            $btn = Html::button("Add Exams",['class'=>'btn btn-primary btn btn-xs']);
                            return Html::a($btn,["university/add-exams", 'id' => $model->id],['title'=>'Add Exams']);
                        },
                    ]
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
<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use softark\duallistbox\DualListbox;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UniversitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $university->name.' Add Courses';
$this->params['subtitle'] = '<h1>Add Courses</h1>';
$this->params['breadcrumbs'][] = ['label' => 'Universities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $university->name;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['courses','id'=>$university->id]];
$this->params['breadcrumbs'][] = 'Add Courses';
?>
<div class="university-index">
	<div class="custumbox box box-info">
		<div class="box-body">
			<?php $form = ActiveForm::begin(); ?>
			<?php
			$options = [
				'multiple' => true,
				'size' => 20,
			];
			echo $form->field($ucmodel, 'courseID')->widget(DualListbox::className(),[
				'items' => $courses,
				'options' => [],
				'clientOptions' => [
					'moveOnSelect' => false,
					'selectedListLabel' => 'Selected Course',
					'nonSelectedListLabel' => 'Course List',
				],
			])->label(false);
			?>
			<div class="form-group text-center">
				<?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block']) ?>
			</div>
			<?php ActiveForm::end(); ?>
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
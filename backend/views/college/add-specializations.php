<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use softark\duallistbox\DualListbox;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UniversitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $courseDetails->course->name.' Add Specializations';
$this->params['subtitle'] = '<h1>Add Specializations</h1>';
$this->params['breadcrumbs'][] = ['label' => 'Colleges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $courseDetails->college->name;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['courses','id'=>$courseDetails->college->id]];
$this->params['breadcrumbs'][] = 'Add Specializations';

echo Yii::$app->message->display();


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
			echo $form->field($ucsmodel, 'course_specializationID')->widget(DualListbox::className(),[
				'items' => $specializations,
				'options' => [],
				'clientOptions' => [
					'moveOnSelect' => false,
					'selectedListLabel' => 'Selected Specializations',
					'nonSelectedListLabel' => 'Specializations List',
				],
			])->label(false);
			?>
			<div class="form-group text-center">
				<?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block']) ?>
			</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
	<div class="custumbox box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Specializations Intake</h3>
		</div>
		<div class="box-body">
			<?php if(!empty($specializationModels)){ ?>
				<?php $form = ActiveForm::begin(); ?>
				<table class="table table-responsive table-bordered">
					<?php  foreach ($specializationModels as $key => $specializationModel) {?>
						<?php if(!empty( $specializationModel->courseSpecialization )){ ?>
						<tr>
							<td><?= $specializationModel->courseSpecialization->specialization->name ?></td>
							<td>
								<?= $form->field($specializationModel, '['.$key.']id')->hiddenInput()->label(false); ?>
								<?= $form->field($specializationModel, '['.$key.']intake')->textInput(['maxlength' => true])->label(false) ?></td>
							</tr>
						<?php } ?>	
						<?php } ?>
					</table>
					<div class="form-group text-center">
						<?= Html::submitButton('Save Specializations Intake', ['class' => 'btn btn-success btn-block']) ?>
					</div>
					<?php ActiveForm::end(); ?>
				<?php }else{ ?>
					<h5>Add Specializations from above list.</h5>
				<?php } ?>
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
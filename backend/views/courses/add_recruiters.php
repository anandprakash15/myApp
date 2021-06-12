<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use softark\duallistbox\DualListbox;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UniversitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $course->name.' Add Recruiters';
$this->params['subtitle'] = '<h1>Add Recruiters</h1>';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $course->name;
$this->params['breadcrumbs'][] = 'Add Recruiters';

echo Yii::$app->message->display();
?>
<div class="recruiters-index">
	<div class="custumbox box box-info">
		<div class="box-body">
			<?php $form = ActiveForm::begin(); ?>
			<?php
			$options = [
				'multiple' => true,
				'size' => 20,
			];
			echo $form->field($csmodel, 'topRecruitersID')->widget(DualListbox::className(),[
				'items' => $recruiters,
				'options' => [],
				'clientOptions' => [
					'moveOnSelect' => false,
					'selectedListLabel' => 'Selected Recruiters',
					'nonSelectedListLabel' => 'Recruiters List',
				],
			])->label(false);
			?>
			<div class="form-group text-center">
				<button id="back_btn" class="btn btn-default"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
				<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
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
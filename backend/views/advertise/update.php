<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Advertise */

$this->title = 'Update Advertise: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Advertises', 'url' => ['index']];
$this->params['breadcrumbs'][] =  $model->id;
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="advertise-update">

	<?= $this->render('_form', [
		'model' => $model,
		'coll_univID' => $coll_univID,
		'program' => $program,
		'course' => $course,
		'col_uni_adv'=>$col_uni_adv
	]) ?>

</div>

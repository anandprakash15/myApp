<?php 
use yii\helpers\Url;

\Yii::$container->set('yii\grid\GridView', 

    [
    'tableOptions' => [
        'class' => 'table table-condensed table-bordered hover table-striped',
    ],
    'layout'=>"{items}\n{summary}\n{pager}",
    'rowOptions' => function ($model, $key, $index, $grid) {
        $url = Url::to(['update','id'=> $model['id']]);
        return ['onclick' => 'location.href="'.$url.'"'];
    },
]);



\Yii::$container->set('kartik\grid\GridView', [
    'containerOptions' => ['class'=>'panel panel-default'],
    'tableOptions' => [
        'class' => 'table table-condensed table-bordered hover',
    ],
    'bordered'=>false,
    'responsiveWrap' => false,
    'responsive'=> true,
    'resizableColumns' => false,
    
    'layout'=>"{items}\n{summary}\n{pager}",
    'rowOptions' => function ($model, $key, $index, $grid) {
        $url = Url::to(['update','id'=> $model['id']]);
        return ['onclick' => 'location.href="'.$url.'"'];
    },
]);

\Yii::$container->set('yii\grid\SerialColumn', [
    'headerOptions' => ['style' => 'width:3%'],
]);


\Yii::$container->set('kartik\grid\ActionColumn', [
    'mergeHeader'=>false,
]);



\Yii::$container->set('yii\bootstrap\ActiveForm', [
    'layout' => 'horizontal',
	'fieldConfig' => [
        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
		'horizontalCssClasses' => [
                 'wrapper' => 'col-sm-8',
                 'error' => '',
                 'label' => 'col-sm-2',
                 'hint' => '',
             ],
	],
]);

\Yii::$container->set('dosamigos\ckeditor\CKEditor', [
    'clientOptions'=>[
        'enterMode' => 2,
        'forceEnterMode'=>false,
        'shiftEnterMode'=>1,
    ],
]);

?>
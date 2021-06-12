<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SpecializationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Front End';
(!empty($model) == 0)?
$this->params['subtitle'] = '<h1>Front End '.Yii::$app->myhelper->getCreatenew($roleid = array(1),'','Add').'</h1>':"";
$this->params['breadcrumbs'][] = $this->title;
$status = Yii::$app->myhelper->getActiveInactive();

echo Yii::$app->message->display();
?>

<div class="specialization-index">
    <div class="custumbox box box-info">
        <div class="box-body">
            <a style="    color: #000;" href="<?= Url::to(['update','id'=>$model->id]) ?>">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [    
                        'label' => 'About',
                        'value' => $status[$model['about_status']],
                    ],
                    [    
                        'label' => 'Privacy',
                        'value' => $status[$model['privacy_status']],
                    ],
                    [    
                        'label' => 'Term And Condition',
                        'value' => $status[$model['term_condition_status']],
                    ],
                    [    
                        'label' => 'Vision',
                        'value' =>  $status[$model['vision_status']],
                    ],
                    [    
                        'label' => 'Mission',
                        'value' => $status[$model['mission_status']],
                    ],
                    [    
                        'label' => 'Disclaimer',
                        'value' => $status[$model['disclaimer_status']],
                    ],
                    [    
                        'label' => 'Faq',
                        'value' => $status[$model['faq_status']],
                    ],
                    [    
                        'label' => 'Contact Us',
                        'value' => $status[$model['contact_us_status']],
                    ],
                    [    
                        'label' => 'Site Map',
                        'value' => $status[$model['site_map_status']],
                    ],
                    [    
                        'label' => 'Why Choose Us',
                        'value' => $status[$model['wcu_status']],
                    ],
                    [    
                        'label' => 'Management Team',
                        'value' => $status[$model['mt_status']],
                    ],
                    [    
                        'label' => 'Careers',
                        'value' => $status[$model['careers_status']],
                    ],
                    [    
                        'label' => 'Our Blog',
                        'value' => $status[$model['ob_status']],
                    ],
                ]
            ]) ?>
        </a>
            <?php /*GridView::widget([
                'striped'=>false,
                'hover'=>true,
                'panel'=>['type'=>'default', 'heading'=>'Front End','after'=>false],
                
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'kartik\grid\SerialColumn'],

                    [
                        'attribute' => 'about_status',
                        'filter' => $status,
                        'value' => function($model)use($status){
                            return $status[$model['about_status']];
                        }
                    ],
                    [
                        'attribute' => 'privacy_status',
                        'filter' => $status,
                        'value' => function($model)use($status){
                            return $status[$model['privacy_status']];
                        }
                    ],
                    [
                        'attribute' => 'term_condition_status',
                        'filter' => $status,
                        'value' => function($model)use($status){
                            return $status[$model['term_condition_status']];
                        }
                    ],
                ],
                'exportConfig'=> [
                    GridView::CSV=>[
                        'label' => 'CSV',
                    ],
                    GridView::EXCEL=>[
                        'label' => 'Excel',
                    ],
                ],
            ]);*/ ?>
        </div>
    </div>
</div>



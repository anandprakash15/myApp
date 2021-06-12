<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Frontend */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Frontends', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$status = Yii::$app->myhelper->getActiveInactive();

?>
<div class="frontend-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

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

</div>

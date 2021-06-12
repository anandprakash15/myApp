<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\College */

$this->title = $model->name;
$this->params['subtitle'] = '<h1>View '.Html::a('Edit', ['update','id'=>$model->id], ['class' => 'btn btn-success btn-xs']).'</h1>';
$this->params['breadcrumbs'][] = ['label' => 'Colleges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo Yii::$app->message->display();
?>
<div class="college-view">
    <div class="custumbox box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Details</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th class="col-md-4">Logo:</th>
                        <td class="col-md-8"><?= Html::img(Url::to($fBasePath.$model->logourl),['class' => 'img-responsive','style'=>'width:100px;height:100px']) ?></td>
                    </tr>                  
                    <tr>
                        <th class="col-md-4">Code:</th>
                        <td class="col-md-8"><?= Yii::$app->myhelper->getCollegeCode($model->code) ?></td>
                    </tr>
                    <tr>
                        <th class="col-md-4">Establish Year:</th>
                        <td class="col-md-8"><?= $model->establish_year ?></td>
                    </tr>
                    <tr>
                        <th class="col-md-4">Ownership:</th>
                        <td class="col-md-8"><?= $model->ownership ?></td>
                    </tr>
                    <tr>
                        <th class="col-md-4">Website Url:</th>
                        <td class="col-md-8"><a target="_blank" href="<?= $model->websiteurl ?>"><?= $model->websiteurl ?></a></td>
                    </tr>
                    <tr>
                        <th class="col-md-4">Brochure:</th>
                        <td class="col-md-8"><a target="_blank" href="<?= Url::to($fBasePath.$model->brochureurl) ?>"><?= $model->brochureurl ?></a></td>
                    </tr>
                    <tr>
                        <th class="col-md-4">Approved By:</th>
                        <td class="col-md-8">
                            <?php foreach($model->approved_by as $id => $approved_by ){ ?>
                               <a href="<?= Url::to(['approved/update','id'=>$id]) ?>" class="btn btn-default btn-xs"><?= $approved_by ?></a> 
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="col-md-4">Accredited By:</th>
                        <td class="col-md-8">
                            <?php foreach($model->accredited_by as $id => $accredited_by ){ ?>
                               <a href="<?= Url::to(['accredited/update','id'=>$id]) ?>" class="btn btn-default btn-xs"><?= $accredited_by ?></a> 
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="col-md-4">Affiliate To:</th>
                        <td class="col-md-8">
                            <?php foreach($model->affiliate_to as $id => $affiliate_to ){ ?>
                             <a href="<?= Url::to(['affiliate/update','id'=>$id]) ?>" class="btn btn-default btn-xs"><?= $affiliate_to ?></a> 
                            <?php } ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="custumbox box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">About</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <?= $model->about ?>
        </div>
    </div>

    <div class="custumbox box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Vission</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <?= $model->vission ?>
        </div>
    </div>

    <div class="custumbox box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Mission</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <?= $model->mission ?>
        </div>
    </div>
    <div class="custumbox box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Location</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <tbody>                  
                    <tr>
                        <th class="col-md-4">Country:</th>
                        <td class="col-md-8"><?= isset($model->country->name)?$model->country->name:"" ?></td>
                    </tr>
                    <tr>
                        <th class="col-md-4">State:</th>
                       <td class="col-md-8"><?= isset($model->state->name)?$model->state->name:"" ?></td>
                    </tr>
                    <tr>
                        <th class="col-md-4">City:</th>
                        <td class="col-md-8"><?= isset($model->city->name)?$model->city->name:"" ?></td>
                    </tr>
                    <tr>
                        <th class="col-md-4">Taluka:</th>
                        <td class="col-md-8"><?= $model->taluka ?></td>
                    </tr>
                    <tr>
                        <th class="col-md-4">District:</th>
                        <td class="col-md-8"><?= $model->district ?></td>
                    </tr>
                    <tr>
                        <th class="col-md-4">Area:</th>
                        <td class="col-md-8"><?= $model->area ?></td>
                    </tr>
                    <tr>
                        <th class="col-md-4">Pincode:</th>
                        <td class="col-md-8"><?= $model->pincode ?></td>
                    </tr>
                    <tr>
                        <th class="col-md-4">Address:</th>
                        <td class="col-md-8"><?= $model->address ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="custumbox box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Contact Details</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <tbody>                  
                    <tr>
                        <th class="col-md-4">Contact:</th>
                        <td class="col-md-8"><?= $model->contact ?></td>
                    </tr>
                    <tr>
                        <th class="col-md-4">Fax:</th>
                        <td class="col-md-8"><?= $model->fax ?></td>
                    </tr>
                    <tr>
                        <th class="col-md-4">Email:</th>
                        <td class="col-md-8"><a href="mailto:<?= $model->email ?>"><?= $model->email ?></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="custumbox box box-danger">
    <div class="box-body">
        <table class="table table-bordered">
            <tbody>                  
                <tr>
                    <th class="col-md-4">Banner Image:</th>
                    <td class="col-md-8"><?= Html::img(Url::to($fBasePath.$model->bannerURL),['class' => 'img-responsive','style'=>'width:100px;height:100px']) ?></td>
                </tr>
            </tbody>
        </table>
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
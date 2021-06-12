<?php 

namespace backend\components;

class Controller extends \yii\base\Component{
	/*Based on Roles assign user to respective layout */
    public function init() {
    	
    	if(\Yii::$app->user->isGuest){
    		\Yii::$app->layout = 'login';
    		\Yii::$app->user->loginUrl = ['site/login'];
        }else{
            \Yii::$app->layout = 'super-admin';
            \Yii::$app->defaultRoute = 'site/dashboard';
            /*It is case sensetive*/
            /*$myrole = \Yii::$app->myhelper->getMyRole();
            if(\Yii::$app->user->identity->company->status == 1){
            	$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]"."/site/logout";
            	\Yii::$app->getResponse()->redirect($actual_link);
            }

            if($myrole == 'admin'){
              \Yii::$app->layout = 'Admin';
            }elseif($myrole == 'trainee'){
                if(empty(\Yii::$app->user->identity->fname)){
                    \Yii::$app->layout = 'updateprofile';
                    $_SESSION['gotomycourses'] = 'yes';
                    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]"."/user/edit";
                    $s = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                    if($s!=$actual_link){
                        \Yii::$app->getResponse()->redirect($actual_link);
                    }
                }else{
                    \Yii::$app->layout = 'Trainee';
                }
            }elseif($myrole == 'trainer'){
              \Yii::$app->layout = 'Trainer';
            }elseif($myrole == 'superadmin'){
              \Yii::$app->layout = 'Superadmin';
            }elseif($myrole == 'manager'){
              \Yii::$app->layout = 'Manager';
            }elseif($myrole == 'moderator'){
                \Yii::$app->layout = 'Moderator';
            }elseif($myrole == 'company head'){
                \Yii::$app->defaultRoute = 'reports/index';
                \Yii::$app->layout = 'Companyhead';
            }elseif($myrole == 'company manager'){
                \Yii::$app->defaultRoute = 'reports/index';
                \Yii::$app->layout = 'Companymanager';
            }elseif($myrole == 'reporting'){
                \Yii::$app->defaultRoute = 'reports/index';
                \Yii::$app->layout = 'Reporting';
            }else{    
                \Yii::$app->layout = 'Student';
            }*/
        }
		parent::init();
    }
}
?>
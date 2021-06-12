<?php

namespace common\components;
use Yii;
use yii\helpers\Html;
use yii\base\Component;
use yii2mod\alert\Alert;

class Message extends Component{
	public $getday;
	
	public function init(){
		parent::init();
		$this->getday = '';
	}

	public function display(){
		foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
			if($key == "success")
			{

				echo Alert::widget([
		        'type' => Alert::TYPE_SUCCESS,
		        'timer'=>'3000',
		        'options' => [
		            'title' => '<strong>'.$key.'</strong>',
		            //'text' => $message,
				     'showConfirmButton'=> true
			        ]
			    ]); 

			}elseif($key == "error"){
				echo Alert::widget([
			        'type' => Alert::TYPE_ERROR,
			        'timer'=>'3000',
			        'options' => [
			            'title' => 'Error',
						'showConfirmButton'=> true
			        ]
			    ]);
			}
		}
	}

}
?>
<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\search\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Cities;
use app\models\States;
use app\models\Countries;
use yii\helpers\ArrayHelper;
use common\models\College;
use yii\db\Query;
use yii\web\Response;
use yii\bootstrap\ActiveForm;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionValidate($id = "")
    {
       if($id != "")
        {
            $model = $this->findModel($id);  
        }else{
            $model = new User();
        }
  
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    public function actionCollegeList($q = null, $id = null) {
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, name AS text')
            ->from('college')
            ->where(['like', 'name', $q])
            ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
           
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => College::find()->where(['id'=>$id])->all()->name];
        }
        return $out;
    }

    public static function actionGetCountrieslist(){
      $result ='';
      $model = \common\models\Countries::find()->all();
      if(!empty($model)){
        $result = ArrayHelper::map($model, 'id', 'name');
      }
      return json_encode($result);
    }

    /*Get coursewise state list and default: India*/
    public static function actionGetStateslist($countryID=101){
      $result = [];
      $model = \common\models\States::find()
      ->where(['countryID'=>$countryID])
      ->all();
      if(!empty($model)){
        $result = ArrayHelper::map($model, 'id', 'name');
      }
      return json_encode($result);
    }

    /*Get statewise city list and default: Maharastra*/
    public static function actionGetCitieslist($stateID=22){
      $result = [];
      $model = \common\models\Cities::find()
      ->where(['stateID'=>$stateID])
      ->all();
      if(!empty($model)){
        $result = ArrayHelper::map($model, 'id', 'name');
      }
      return json_encode($result);
    }
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', 'Created Successfully.');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', 'Updated Successfully.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

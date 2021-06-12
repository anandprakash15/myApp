<?php

namespace backend\controllers;

use Yii;
use common\models\NewsArtical;
use common\models\search\NewsArticalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\Program;
use common\models\University;
use common\models\College;
use yii\web\Response;
use yii\db\Query;

/**
 * NewsArticalController implements the CRUD actions for NewsArtical model.
 */
class NewsArticalController extends Controller
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

    /**
     * Lists all NewsArtical models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsArticalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single NewsArtical model.
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
     * Creates a new NewsArtical model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NewsArtical();

        if ($model->load(Yii::$app->request->post())) {
            if(isset($_POST['NewsArtical']['startDate']) && !empty($_POST['NewsArtical']['startDate'])){
                $model->startDate = date('Y-m-d',strtotime($_POST['NewsArtical']['startDate']));
            }
            if(isset($_POST['NewsArtical']['endDate']) && !empty($_POST['NewsArtical']['endDate'])){
                $model->endDate = date('Y-m-d',strtotime($_POST['NewsArtical']['endDate']));
            }
            $model->save();
            \Yii::$app->getSession()->setFlash('success', 'Created Successfully.');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'program' => [],
            'coll_univ_examid' => [],
        ]);
    }

    public function actionSearchList($q = null,$type=null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q) && !is_null($type)) {
            $query = new Query;
            switch ($type) {
                case 1:
                    $from = "university";
                    break;
                case 2:
                    $from = "college";
                    break;
                case 3:
                    $from = "exam";
                    break;
                
                default:
                    $from='';
                    break;
            }
            if(!empty($from)){
                $query->select(["id", new \yii\db\Expression("name AS text")])
                ->from($from)
                ->where(['like', 'name', $q])
                ->andWhere(['status'=>1])
                ->limit(20);
                $command = $query->createCommand();
                $data = $command->queryAll();
                $out['results'] = array_values($data);
            }
        }
        return $out;
    }



    /**
     * Updates an existing NewsArtical model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $program = $coll_univ_examid = [];

        if(!empty($model->programID)){
            $program = ArrayHelper::map(Program::find()->where(['id'=>$model->programID])->asArray()->all(),'id','name');
        }

        if(!empty($model->coll_univ_examid)){
            switch ($model->type) {
                case 1:
                    $coll_univ_examid = ArrayHelper::map(University::find()->where(['id'=>$model->coll_univ_examid])->asArray()->all(),'id','name');
                    break;
                case 2:
                    $coll_univ_examid = ArrayHelper::map(College::find()->where(['id'=>$model->coll_univ_examid])->asArray()->all(),'id','name');
                    break;
                case 3:
                    $coll_univ_examid = ArrayHelper::map(Exam::find()->where(['id'=>$model->coll_univ_examid])->asArray()->all(),'id','name');
                    break;
                
                default:
                    break;
            }
            
        }

        if ($model->load(Yii::$app->request->post())) {
           
           if(isset($_POST['NewsArtical']['startDate']) && !empty($_POST['NewsArtical']['startDate'])){
                $model->startDate = date('Y-m-d',strtotime($_POST['NewsArtical']['startDate']));
            }
            if(isset($_POST['NewsArtical']['endDate']) && !empty($_POST['NewsArtical']['endDate'])){
                $model->endDate = date('Y-m-d',strtotime($_POST['NewsArtical']['endDate']));
            }
            $model->save();
            \Yii::$app->getSession()->setFlash('success', 'Updated Successfully.');
            return $this->redirect(['index']);

        }

        return $this->render('update', [
            'model' => $model,
            'program' => $program,
            'coll_univ_examid' => $coll_univ_examid,
        ]);
    }

    /**
     * Deletes an existing NewsArtical model.
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
     * Finds the NewsArtical model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NewsArtical the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NewsArtical::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

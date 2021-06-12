<?php

namespace backend\controllers;

use Yii;
use common\models\Advertise;
use common\models\University;
use common\models\Courses;
use common\models\College;
use common\models\Program;
use common\models\CollegeUniversityAdvpurpose;
use common\models\search\AdvertiseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * AdvertiseController implements the CRUD actions for Advertise model.
 */
class AdvertiseController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Advertise models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdvertiseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Advertise model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }*/

    /**
     * Creates a new Advertise model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Advertise();

        if ($model->load(Yii::$app->request->post())) {
            $model->fromDate = date('Y-m-d',strtotime($model->fromDate));
            $model->toDate = date('Y-m-d',strtotime($model->toDate));
            if(!$model->save()){
                print_r($model);
                exit;
            }
            \Yii::$app->getSession()->setFlash('success', 'Successfully.');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'coll_univID' => [],
            'program' => [],
            'course' => [],
            'col_uni_adv'=>[]
        ]);
    }

    /**
     * Updates an existing Advertise model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $coll_univID = $program = $course = $col_uni_adv = [];
        if($model->type == 1){
            $coll_univID = ArrayHelper::map(University::find()->where(['id'=>$model->coll_univID])->asArray()->all(),'id','name');
        }else{
            $coll_univID = ArrayHelper::map(College::find()->where(['id'=>$model->coll_univID])->asArray()->all(),'id','name');
        }

        if(!empty($model->college_university_advpurposeID)){
            $col_uni_adv = ArrayHelper::map(CollegeUniversityAdvpurpose::find()->where(['id'=>$model->college_university_advpurposeID])->asArray()->all(),'id','url');
        }
        if(!empty($model->programID)){
            $program = ArrayHelper::map(Program::find()->where(['id'=>$model->programID])->asArray()->all(),'id','name');
        }

        if(!empty($model->courseID)){
            $course = ArrayHelper::map(Courses::find()->where(['id'=>$model->courseID])->asArray()->all(),'id','name');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', 'Updated Successfully.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'coll_univID' => $coll_univID,
            'program' => $program,
            'course' => $course,
            'col_uni_adv'=>$col_uni_adv
        ]);
    }

    /**
     * Deletes an existing Advertise model.
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
     * Finds the Advertise model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Advertise the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Advertise::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
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
                    $from = "college";
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

    public function actionCourseList($q = null,$type=null,$coll_univID=null,$programID=null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q) && !is_null($type)) {
            $query = new Query;
            switch ($type) {
                case 1:
                    $where = "university_college_course.universityID = $coll_univID";
                    break;
                case 2:
                    $where = "university_college_course.collegeID = $coll_univID";
                    break;
                case 3:
                    $where = "university_college_course.collegeID = $coll_univID";
                    break;
                
                default:
                    $where='';
                    break;
            }
            if(!empty($programID)){
                $where .= " and courses.programID = $programID";
            }
            if(!empty($where)){
                $query->select(["university_college_course.id", new \yii\db\Expression("courses.name AS text")])
                ->from('university_college_course')
                ->leftjoin('courses','courses.id = university_college_course.courseID')
                ->where(['like', 'courses.name', $q])
                ->andWhere($where)
                ->andWhere(['courses.status'=>1])
                ->limit(20);
                $command = $query->createCommand();
                $data = $command->queryAll();
                $out['results'] = array_values($data);
            }
        }
        return $out;
    }

    public function actionGetAdvertiseContent($q="",$type,$coll_univID,$gtype){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $query = new Query;
        $items = [];
        if(!empty($type) && !empty($coll_univID) && !empty($gtype)){


            $query->select(['*'])
            ->from('college_university_advpurpose')
            ->where(['like', 'url', $q])
            ->andWhere(['status'=>1,'type'=>$type,'coll_univID'=>$coll_univID,"gtype"=>$gtype]);
            $command = $query->createCommand();
            $items = $command->queryAll();
            foreach ($items as $key => $item) {
                $items[$key]['fullpath'] = Yii::$app->myhelper->getFileBasePath($item['type'],$item['coll_univID'])."advertisement/".$item['url'];
            }
        }
        return ['items'=>$items];
    }
}

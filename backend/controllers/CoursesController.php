<?php

namespace backend\controllers;

use Yii;
use common\models\Courses;
use common\models\Program;
use common\models\Specialization;
use common\models\search\CoursesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\bootstrap\ActiveForm;
use common\models\ProgramCategory;
use common\models\CourseSpecialization;
use common\models\CourseRecruiters;
use common\models\TopRecruiters;
use common\models\Exam;

/**
 * CoursesController implements the CRUD actions for Courses model.
 */
class CoursesController extends Controller
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
     * Lists all Courses models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CoursesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Courses model.
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
     * Creates a new Courses model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Courses();
        $model->medium_of_teaching = 37;
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){

                \Yii::$app->getSession()->setFlash('success', 'Created Successfully.');
            }else{
                \Yii::$app->getSession()->setFlash('error', 'Error Occurred.');
            }
           
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'specialization'=> [],
            'program' => [],
            'program_categoryID' => [],
            'exams' => [],
        ]);
    }

    /**
     * Updates an existing Courses model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$redirect="")
    {
        $model = $this->findModel($id);
        $program= []; $specialization = $program_categoryID = $exams =[];
        if(!empty($model->programID)){
           
            $program = ArrayHelper::map(Program::find()->where(['id'=>$model->programID])->asArray()->all(),'id','name');
        }

        if(!empty($model->specializationID)){
            $specialization = ArrayHelper::map(Specialization::find()->where(['id'=>$model->specializationID])->asArray()->all(),'id','name');
        }

        if(!empty($model->program_categoryID)){
            $program_categoryID = ArrayHelper::map(ProgramCategory::find()->where(['id'=>$model->program_categoryID])->asArray()->all(),'id','name');
        }

        if ($model->load(Yii::$app->request->post())) {

            if($model->save()){
                \Yii::$app->getSession()->setFlash('success', 'Updated Successfully.');
            }else{
                //print_r($model);exit;
                \Yii::$app->getSession()->setFlash('error', 'Error Occurred.');
            }

            if($redirect == "program_courses"){
                return $this->redirect(['program/courses','id'=>$model->programID]);
            }else{
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'specialization'=> $specialization,
            'program' => $program,
            'program_categoryID' => $program_categoryID,
            'exams' => $exams,
        ]);
    }

    /**
     * Deletes an existing Courses model.
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

    public function actionAddSpecializations($id){
        $course = $this->findModel($id);
        $specializations = ArrayHelper::map(Specialization::find()->where(['status'=>1])->all(),'id','name');
        $csmodel = new CourseSpecialization();


        $oldSpecializations = ArrayHelper::getColumn(CourseSpecialization::find()->where(['courseID'=>$course->id])->asArray()->all(),'specializationID');


        
        $csmodel->specializationID = $oldSpecializations;

        $csmodel->courseID = $course->id;

        if ($csmodel->load(Yii::$app->request->post())) {

            $newSpecializations = [];
            if(!empty($csmodel->specializationID)){
                $newSpecializations = array_diff((array)$csmodel['specializationID'], (array)$oldSpecializations);
            }
            $deletedSpecializations = array_diff((array)$oldSpecializations,(array)$csmodel['specializationID']);

            foreach ($newSpecializations as $key => $specialization) {
                $ncsmodel = new CourseSpecialization();
                $ncsmodel->courseID = $course->id;
                $ncsmodel->specializationID = $specialization;
                if(!$ncsmodel->save()){
                    //print_r($nucmodel);exit;
                }    
            }

            if(!empty($deletedSpecializations))
            {
                CourseSpecialization::deleteAll(['courseID' => $course->id, 'specializationID' =>  array_values($deletedSpecializations)]);
            }

            \Yii::$app->getSession()->setFlash('success', 'Specializations successfully added in course '.$course->name.".");
            
            return $this->redirect(['add-specializations','id'=>$course->id]);
        }

        
        return $this->render('add_specializations', [
            'course' => $course,
            'specializations'=>$specializations,
            'csmodel' => $csmodel,
        ]);
    }

    /*public function actionAddRecruiters($id){
        $course = $this->findModel($id);
        $recruiters = ArrayHelper::map(TopRecruiters::find()->where(['status'=>1])->all(),'id','short_name');
        $csmodel = new CourseRecruiters();


        $oldRecruiters = ArrayHelper::getColumn(CourseRecruiters::find()->where(['courseID'=>$course->id])->asArray()->all(),'topRecruitersID');


        
        $csmodel->topRecruitersID = $oldRecruiters;

        $csmodel->courseID = $course->id;

        if ($csmodel->load(Yii::$app->request->post())) {
            $newRecruiters = [];
            if(!empty($csmodel->topRecruitersID)){
               $newRecruiters = array_diff((array)$csmodel['topRecruitersID'], (array)$oldRecruiters); 
            }
            
            $deletedSpecializations = array_diff((array)$oldRecruiters,(array)$csmodel['topRecruitersID']);

            foreach ($newRecruiters as $key => $recruiter) {
                $ncsmodel = new CourseRecruiters();
                $ncsmodel->courseID = $course->id;
                $ncsmodel->topRecruitersID = $recruiter;
                if(!$ncsmodel->save()){
                    //print_r($nucmodel);exit;
                }    
            }

            if(!empty($deletedSpecializations))
            {
                CourseRecruiters::deleteAll(['courseID' => $course->id, 'topRecruitersID' =>  array_values($deletedSpecializations)]);
            }

            \Yii::$app->getSession()->setFlash('success', 'Recruiters successfully added in course '.$course->name.".");
            
            return $this->redirect(['add-recruiters','id'=>$course->id]);
        }

        
        return $this->render('add_recruiters', [
            'course' => $course,
            'recruiters'=>$recruiters,
            'csmodel' => $csmodel,
        ]);
    }*/

    /**
     * Finds the Courses model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Courses the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Courses::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCourseList($q = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select(["id", new \yii\db\Expression("name AS text")])
            ->from('courses')
            ->where(['like', 'name', $q])
            ->andWhere(['status'=>1])
            ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        return $out;
    }

    public function actionValidate($id = "")
    {
       if($id != "")
        {
            $model = $this->findModel($id);  
        }else{
            $model = new Courses();
        }
  
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

}

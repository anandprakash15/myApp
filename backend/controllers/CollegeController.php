<?php

namespace backend\controllers;

use Yii;
use common\models\College;
use common\models\University;
use common\models\Courses;
use common\models\search\CollegeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\web\Response;
use yii\bootstrap\ActiveForm;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use common\models\UniversityCollegeCourse;
use common\models\search\UniversityCollegeCourseSearch;
use common\models\CollegeGallery;
use yii\web\UploadedFile;
use common\models\Approved;
use common\models\Accredite;
use common\models\Accredited;
use common\models\Affiliate;
use common\models\CourseDetails;
use yii\helpers\ArrayHelper;
use common\models\search\FacilitySearch;
use common\models\Facility;
use common\models\search\ReviewSearch;
use common\models\Review;
use common\models\CollegeUniversityAdvpurpose;
use common\models\search\CollegeUniversityAdvpurposeSearch;
use common\models\CourseSpecialization;
use common\models\UniversityCollegeCourseSpecialization;
use common\models\Exam;
use common\models\FacilityGallery;
use yii\base\Model;

/**
 * CollegeController implements the CRUD actions for College model.
 */
class CollegeController extends Controller
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
     * Lists all College models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CollegeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single College model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout= "college";
        $model = $this->findModel($id);
        $fBasePath = Yii::$app->myhelper->getFileBasePath(2,$model->id);

        if(!empty($model->approved_by)){
            $model->approved_by = ArrayHelper::map(Approved::find()->where(new \yii\db\Expression("id IN(".$model->approved_by.")"))->asArray()->all(),'id','name');
        }else{
            $model->approved_by = [];
        }

        if(!empty($model->accredited_by)){
            $model->accredited_by = ArrayHelper::map(Accredited::find()->where(new \yii\db\Expression("id IN(".$model->accredited_by.")"))->asArray()->all(),'id','name');
        }else{
            $model->accredited_by = [];
        }

        if(!empty($model->affiliate_to)){
            $model->affiliate_to = ArrayHelper::map(Affiliate::find()->where(new \yii\db\Expression("id IN(".$model->affiliate_to.")"))->asArray()->all(),'id','name');
        }else{
            $model->affiliate_to = [];
        }
        
        $ownership = Yii::$app->myhelper->getOwnership();
        if(!empty($model->ownership) && isset($ownership[$model->ownership])){

            $model->ownership = $ownership[$model->ownership];
        } 

        return $this->render('view', [
            'model' => $model,
            'fBasePath'=>$fBasePath
        ]);  
    }


    public function actionCourses($id){
        $this->layout= "college";
        $college = $this->findModel($id);

        $searchModel = new UniversityCollegeCourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$college->id,'college');
        
        return $this->render('courses', [
            'college' => $college,
            'dataProvider'=> $dataProvider,
            'searchModel'=> $searchModel,
        ]);
    }


    public function actionCourseDetails($id,$uccID = null)
    {
        $this->layout= "college";
        $college = $this->findModel($id);
        Yii::$app->params['cTitle'] = $college->name;
        Yii::$app->params['cID'] = $college->id;

        if($uccID==null){
            $uccModel = new UniversityCollegeCourse();
            $model = new CourseDetails();
        }else{
            $uccModel = UniversityCollegeCourse::find()->joinWith(['course'])->where(['university_college_course.id'=>$uccID])->one();
            $model = CourseDetails::findOne(['uccID'=>$uccModel->id]);
            if(empty($model)){
                $model = new CourseDetails();
            }
        }
        $model->scenario = CourseDetails::SCENARIO_COLLEGE_COURSE;
        $university =  $course = [];

        if(!empty($uccModel->universityID)){
            $university = ArrayHelper::map(University::find()->where(['id'=>$uccModel->universityID])->asArray()->all(),'id','name');
        }

        if($uccModel->courseID){
            $course = ArrayHelper::map(Courses::find()->where(['id'=>$uccModel->courseID])->asArray()->all(),'id','name');
        }

        $uccModel->collegeID = $college->id;
        if(empty($model->affiliation_type)){
            $model->affiliation_type = 1;
        }

        $approved_by = $exams =  [];

        if(!empty($model->approved_by)){

            $approved_by = ArrayHelper::map(Approved::find()->where(new \yii\db\Expression("id IN(".$model->approved_by.")"))->asArray()->all(),'id','name');
            $model->approved_by = explode(",",$model->approved_by);
        }

        if(!empty($model->entrance_exams_accepted)){
            $model->entrance_exams_accepted = explode(",", $model->entrance_exams_accepted);
            $exams = ArrayHelper::map(Exam::find()->where(['id'=>$model->entrance_exams_accepted])->asArray()->all(),'id','exam_name');
        }

        if ($model->load(Yii::$app->request->post()) && $uccModel->load(Yii::$app->request->post())) 
        {
            $model->approved_by = implode(",",(array) $model->approved_by);
            $model->entrance_exams_accepted = @implode(",", $model->entrance_exams_accepted);
            if($model->affiliation_type == 1){
                $uccModel->universityID = "";
            }else{
                $model->course_mode = "";
                $model->eligibility_criteria = "";
                $model->course_curriculum = "";
                $model->entrance_exams_accepted = "";
            }

            $uccModel->status = 1;
            if($uccModel->save()){
               $model->uccID =  $uccModel->id;
                if($model->save()){
                    \Yii::$app->getSession()->setFlash('success', 'Successfully.');
                }else{
                    //print_r($model);exit;
                    \Yii::$app->getSession()->setFlash('error', 'Error Occurred.');
                }
            }
            return $this->redirect(['courses','id'=>$college->id]);
        }
        

        return $this->render('course-details', [
            'model' => $model,
            'uccModel'=>$uccModel,
            'college' => $college,
            'university' => $university,
            'course' => $course,
            'exams' => $exams,
            'approved_by'=>$approved_by
        ]);
    }

    
    public function actionAddSpecializations($id)
    {
        $this->layout= "college";
        $courseDetails = UniversityCollegeCourse::findOne($id);
        Yii::$app->params['cTitle'] = $courseDetails->college->name;
        Yii::$app->params['cID'] = $courseDetails->college->id;

        $specializations = ArrayHelper::map(CourseSpecialization::find()->joinWith(['specialization'])->where(['courseID'=>$courseDetails->course->id])->all(),'id','specialization.name');

        $ucsmodel = new UniversityCollegeCourseSpecialization();
        $ucsmodel->type = 2;
        $specializationModels = UniversityCollegeCourseSpecialization::find()->joinWith(['courseSpecialization'])->where(['coll_univID'=>$courseDetails->id,'type'=>2])->all();
        $oldSpecializations = ArrayHelper::getColumn($specializationModels,'course_specializationID');

        
        $ucsmodel->course_specializationID = $oldSpecializations;

        $ucsmodel->coll_univID = $courseDetails->id;

        if ($ucsmodel->load(Yii::$app->request->post())) {
            Model::loadMultiple($specializationModels, Yii::$app->request->post());
            foreach ($specializationModels as $key => $specializationModel) {
                $specializationModel->save();
            }
            $newSpecializations = array_diff((array)$ucsmodel['course_specializationID'], (array)$oldSpecializations);

            $deletedSpecializations = array_diff((array)$oldSpecializations,(array)$ucsmodel['course_specializationID']);

            foreach ($newSpecializations as $key => $specialization) {
                $nucsmodel = new UniversityCollegeCourseSpecialization();
                $nucsmodel->coll_univID = $courseDetails->id;
                $nucsmodel->course_specializationID = $specialization;
                $nucsmodel->type = 2;
                $nucsmodel->status = 1;
                if(!$nucsmodel->save()){
                    //print_r($nucsmodel);exit;
                }    
            }

            if(!empty($deletedSpecializations))
            {
                UniversityCollegeCourseSpecialization::deleteAll(['coll_univID' => $courseDetails->id, 'course_specializationID' =>  array_values($deletedSpecializations)]);
            }

            \Yii::$app->getSession()->setFlash('success', 'Specialization has been successfully saved.');
            
            return $this->redirect(['add-specializations','id'=>$courseDetails->id]);
        }

        
        return $this->render('add-specializations', [
            'courseDetails' => $courseDetails,
            'specializations'=>$specializations,
            'ucsmodel' => $ucsmodel,
            'specializationModels' => $specializationModels
        ]);
    }

    public function actionGallery($id,$type){
        $this->layout= "college";
        $college = $this->findModel($id);
        $fileType = "image";
        $fileList = CollegeGallery::find()->where(['collegeID'=>$college->id,'type'=>$type])->all();
        $allowedFileExtensions = ['jpg','jpeg','png'];
        if($type == 2){
            $fileType = "video";
            $allowedFileExtensions = ['mp4','avi','mkv'];
        }
        $fBasePath = Yii::$app->myhelper->getFileBasePath(2,$college->id,$type);

        return $this->render('gallery', [
            'college' => $college,
            'fileList' => $fileList,
            'type'=> $type,
            'allowedFileExtensions'=> $allowedFileExtensions,
            'fileType'=>$fileType,
            'fBasePath' => $fBasePath
        ]);
    }

    public function actionFileUpload($id,$type)
    {

        if(!empty($id))
        {
            $uploadPath = Yii::$app->myhelper->getUploadPath(2,$id,$type);
            
            $successfiles = [];
            $errorfiles = [];
            FileHelper::createDirectory($uploadPath,0775,true);
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $files = UploadedFile::getInstancesByName('ufiles');

            foreach ($files as $key => $file) {
                $model = new CollegeGallery();
                $model->type = $type;
                $model->collegeID = $id;
                $filename = time().$key;
                $model->url = $filename.'.'.pathinfo($file->name, PATHINFO_EXTENSION);
                $model->status = 1;

                if($model->save()){
                    array_push($successfiles, $file->name);
                    $filePath = $uploadPath.$model->url;
                    if($file->saveAs($filePath)){
                        array_push($successfiles, $file->name);

                        if($type == 2){
                            //-vf scale=300:300
                            $thumbPath = $uploadPath.$filename."-thumb.png";
                            Yii::$app->myhelper->videoThumb($filePath,$thumbPath);
                        }
                    }
                }else{
                   // print_r($model);exit;
                    array_push($errorfiles, $file->name);
                }   
            }
            $message =  "Successfully uploaded Files ".implode(", ", $successfiles);
            $message .=  "<br>Error Files ".implode(", ", $errorfiles);

            return ['success'=>$message];
        }
    }

    public function actionDeleteFile($id,$property){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model = College::findOne($id);
        $filename = $model->$property;
        $model->$property = "";
        if($model->save()){
            $uploadPath = Yii::$app->myhelper->getUploadPath(2,$id);
            @unlink($uploadPath.$filename);
            return ['success'=>false];
        }

    }
    public function actionDeleteGalleryFile($id){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $file = CollegeGallery::findOne($id);

        if(!empty($file))
        {
            if($file->delete()){
                $uploadPath = Yii::$app->myhelper->getUploadPath(2,$file->collegeID,$file->type);
                @unlink($uploadPath.$file->url);
                if($file->type == 2){
                    @unlink($uplaodPath.pathinfo($file->url, PATHINFO_FILENAME)."-thumb.png");
                }
                return ['success'=>true];
            }
        }
        return ['error'=>true,'msg'=>'Error occured while deleting the file.'];
    }



    public function actionFacility($id)
    {
        $this->layout= "college";
        $college = $this->findModel($id);

        $searchModel = new FacilitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$college->id,'college');
        
        return $this->render('facility', [
            'college' => $college,
            'dataProvider'=> $dataProvider,
            'searchModel'=> $searchModel,
        ]);
    }

    public function actionFacilityGalleryDelete($id,$key){
        $fgID = Yii::$app->myhelper->getDecryptID($key);
        if(!empty($fgID))
        {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if (($model = FacilityGallery::findOne($fgID)) !== null) {
                $uplaodPath = Yii::$app->myhelper->getUploadPath(2,$id)."facility/";
                $filePath = $uplaodPath.$model->url;
                @unlink($filePath);
                if($model->type == 2){
                    @unlink($uplaodPath.pathinfo($model->url, PATHINFO_FILENAME)."-thumb.png");
                }
                if($model->delete()){
                    return ['success'=>true];
                }
            }
        }
        return ['error'=>true,'msg'=>'Error occured while deleting the file.'];
    }

    public function actionFacilityDetails($id,$fid = null)
    {
        $this->layout= "college";
        $college = $this->findModel($id);
        $fileList=[];
        $fBasePath = Yii::$app->myhelper->getFileBasePath(2,$college->id)."facility/";
        if (($model = Facility::findOne(['id'=>$fid])) == null) {
            $model = new Facility();
        }else{
            $fileList = FacilityGallery::find()->where(['uc_type'=>2,'facilityID'=>$model->id])->all();
        }
        
        $model->coll_univID = $id;
        $model->type = 2;

        $facilityGallery = new FacilityGallery();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $uploadPath = Yii::$app->myhelper->getUploadPath(2,$id)."facility/";
            FileHelper::createDirectory($uploadPath,0775,true);

            $files = UploadedFile::getInstances($facilityGallery, 'imagevideo');
            foreach ($files as $key => $file) {
                $facilityGallery = new FacilityGallery();
                $facilityGallery->type = 2;
                if(strpos($file->type, "image/") !== false){
                    $facilityGallery->type = 1;
                }
                $facilityGallery->uc_type = 2;
                $facilityGallery->facilityID = $model->id;
                $filename = time().$key;
                $facilityGallery->url = $filename.'.'.pathinfo($file->name, PATHINFO_EXTENSION);
                if($facilityGallery->save()){
                    $filePath = $uploadPath.$facilityGallery->url;
                    if($file->saveAs($filePath)){
                        if($facilityGallery->type == 2){
                            $thumbPath = $uploadPath.$filename."-thumb.png";
                            Yii::$app->myhelper->videoThumb($filePath,$thumbPath);
                        }
                    }
                }
            }

            \Yii::$app->getSession()->setFlash('success', 'Successful.');
            return $this->redirect(['facility-details','id'=>$college->id,'fid'=>$model->id]);
        }

        return $this->render('facility-details', [
            'model' => $model,
            'college' => $college,
            'facilityGallery'=>$facilityGallery,
            'fBasePath'=>$fBasePath,
            'fileList' => $fileList
        ]);
    }

    /**
     * Creates a new College model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new College();

        if ($model->load(Yii::$app->request->post())) {
           
            $model->approved_by = implode(",",(array) $model->approved_by);
            $model->accredited_by = implode(",",(array) $model->accredited_by);
            $model->affiliate_to = implode(",",(array) $model->affiliate_to);

            $bannerImg = UploadedFile::getInstance($model, 'bannerImg');
            if(!empty($bannerImg))
            {
                $model->bannerURL = "banner.".pathinfo($bannerImg->name, PATHINFO_EXTENSION);
            }

            $brochureFile = UploadedFile::getInstance($model, 'brochureFile');
            if(!empty($brochureFile))
            {
                $model->brochureurl = "brochure.".pathinfo($brochureFile->name, PATHINFO_EXTENSION);
            }
            
            $logoImg = UploadedFile::getInstance($model, 'logoImg');
            if(!empty($logoImg))
            {
                $model->logourl = "logo.".pathinfo($logoImg->name, PATHINFO_EXTENSION);
            }

            if($model->save()){
                $uploadPath = Yii::$app->myhelper->getUploadPath(2,$model->id);
                FileHelper::createDirectory($uploadPath,0775,true);
                if(!empty($bannerImg))
                {
                    $bannerImg->saveAs($uploadPath.$model->bannerURL);
                }
                if(!empty($brochureFile))
                {
                    $brochureFile->saveAs($uploadPath.$model->brochureurl);
                }

                if(!empty($logoImg))
                {
                    $logoImg->saveAs($uploadPath.$model->logourl);
                }
                \Yii::$app->getSession()->setFlash('success', 'Created Successfully.');
            }else{
                \Yii::$app->getSession()->setFlash('error', 'Error occured while creating.');
            }
            return $this->redirect(['view','id'=>$model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'approved_by' => [],
            'accredited_by' => [],
            'affiliate_to'=>[]
        ]);
    }

    /**
     * Updates an existing College model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->layout= "college";
        $model = $this->findModel($id);
        
        $oldlogoURL = $model->logourl;
        $approved_by = $accredited_by = $affiliate_to = [];
        if(!empty($model->approved_by)){
           
            $approved_by = ArrayHelper::map(Approved::find()->where(new \yii\db\Expression("id IN(".$model->approved_by.")"))->asArray()->all(),'id','name');
            $model->approved_by = explode(",",$model->approved_by);
        }

        if(!empty($model->accredited_by)){
           
            $accredited_by = ArrayHelper::map(Accredited::find()->where(new \yii\db\Expression("id IN(".$model->accredited_by.")"))->asArray()->all(),'id','name');
            $model->accredited_by = explode(",",$model->accredited_by);
        }

        if(!empty($model->affiliate_to)){
           
            $affiliate_to = ArrayHelper::map(Affiliate::find()->where(new \yii\db\Expression("id IN(".$model->affiliate_to.")"))->asArray()->all(),'id','name');
            $model->affiliate_to = explode(",",$model->affiliate_to);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->approved_by = implode(",",(array) $model->approved_by);
            $model->accredited_by = implode(",",(array) $model->accredited_by);
            $model->affiliate_to = implode(",",(array) $model->affiliate_to);

            $uploadPath = Yii::$app->myhelper->getUploadPath(2,$model->id);
            FileHelper::createDirectory($uploadPath,0775,true);
            
            $bannerImg = UploadedFile::getInstance($model, 'bannerImg');
            
            if(!empty($bannerImg))
            {

                $model->bannerURL = "banner.".pathinfo($bannerImg->name, PATHINFO_EXTENSION);
            }

            $brochureFile = UploadedFile::getInstance($model, 'brochureFile');
            if(!empty($brochureFile))
            {
                $model->brochureurl = "brochure.".pathinfo($brochureFile->name, PATHINFO_EXTENSION);
            }
            
            $logoImg = UploadedFile::getInstance($model, 'logoImg');
            if(!empty($logoImg))
            {
                $model->logourl = "logo.".pathinfo($logoImg->name, PATHINFO_EXTENSION);
            }

            if($model->save()){
                if(!empty($bannerImg))
                {
                    @unlink($uploadPath.$oldbannerURL);
                    $bannerImg->saveAs($uploadPath.$model->bannerURL);
                }
                if(!empty($brochureFile))
                {
                    @unlink($uploadPath.$oldbrochureURL);
                    $brochureFile->saveAs($uploadPath.$model->brochureurl);
                }

                if(!empty($logoImg))
                {
                    @unlink($uploadPath.$oldlogoURL);
                    $logoImg->saveAs($uploadPath.$model->logourl);
                }

                \Yii::$app->getSession()->setFlash('success', 'Updated Successfully.');
            }else{
                //print_r($model);exit;
                \Yii::$app->getSession()->setFlash('error', 'Error occured while creating.');
            }
            return $this->redirect(['view','id'=>$model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'approved_by' => $approved_by,
            'accredited_by'=>$accredited_by,
            'affiliate_to'=>$affiliate_to
        ]);
    }



     public function actionAdvertiseMaterials($id)
    {
        $this->layout= "college";
        $college = $this->findModel($id);

        $searchModel = new CollegeUniversityAdvpurposeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$college->id,'college');
        
        return $this->render('advertise-materials', [
            'college' => $college,
            'dataProvider'=> $dataProvider,
            'searchModel'=> $searchModel,
        ]);
    }

    public function actionAdvertiseMaterialsDetails($id,$fid = null)
    {
        $this->layout= "college";
        $college = $this->findModel($id);

        if (($model = CollegeUniversityAdvpurpose::findOne(['id'=>$fid])) == null) {
            $model = new CollegeUniversityAdvpurpose();
            $model->scenario = "create";

        }
       
        $model->coll_univID  = $id;
        $model->type = 2;
        $imgPreview = [];
        $imgPreviewConfig = [];
        $oldFile = "";
        $uploadPath = Yii::$app->myhelper->getUploadPath(2,$college->id)."advertisement/";
        $fViewPath= Yii::$app->myhelper->getFileBasePath(2,$college->id)."advertisement/";
        if(!empty($model->url)){
            $imgPreview = [$fViewPath.$model->url];
            if($model->gtype == 6)
            {
                $imgPreviewConfig = ["type" => "video", "filetype"=> "video/mp4","downloadUrl"=> $fViewPath.$model->url,'showRemove'=>false];
            }else{
                $imgPreviewConfig = ["downloadUrl"=> true,'showRemove'=>false,"downloadUrl"=> $fViewPath.$model->url];
            }
            $oldFile = $uploadPath.$model->url;
        }

        if ($model->load(Yii::$app->request->post())) {
            $urlImage = UploadedFile::getInstance($model, 'urlImage');
            $filename = time();
            if(!empty($urlImage))
            {
                $model->url = $filename.".".pathinfo($urlImage->name, PATHINFO_EXTENSION);
                $model->urlImage = $urlImage->name;
            }
            if($model->save()){
                
                FileHelper::createDirectory($uploadPath,0777,true);
                if(!empty($urlImage))
                {
                    $filePath = $uploadPath.$model->url;
                    $urlImage->saveAs($filePath);

                    if($oldFile != ""){
                        @unlink($oldFile);
                        if($model->gtype == 6){
                            @unlink($uploadPath.pathinfo($oldFile, PATHINFO_FILENAME )."-thumb.png");
                        }
                    }
                    if($model->gtype == 6){
                        $thumbPath = $uploadPath.$filename."-thumb.png";
                        Yii::$app->myhelper->videoThumb($filePath,$thumbPath);
                    }
                }
            }
            \Yii::$app->getSession()->setFlash('success', 'Successful.');
            return $this->redirect(['advertise-materials','id'=>$college->id]);
        }


       return $this->render('advertise-materials-details', [
        'model' => $model,
        'college' => $college,
        'imgPreview'=>$imgPreview,
        'imgPreviewConfig'=> $imgPreviewConfig
    ]);
    }

    public function actionReview($id){
        $this->layout= "college";
        $college = $this->findModel($id);

        $searchModel = new ReviewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$college->id,'college');
        
        return $this->render('review', [
            'college' => $college,
            'dataProvider'=> $dataProvider,
            'searchModel'=> $searchModel,
        ]);
    }

    public function actionReviewDetails($id,$rid = null)
    {
        $this->layout= "college";
        $college = $this->findModel($id);

        $model = Review::findOne(['id'=>$rid]);    
        if (($model = Review::findOne(['id'=>$rid])) == null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           \Yii::$app->getSession()->setFlash('success', 'Successful.');
           return $this->redirect(['review','id'=>$id]);
       }


       return $this->render('review-details', [
            'model' => $model,
            'college' => $college,
        ]);
    }

    /**
     * Deletes an existing College model.
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
     * Finds the College model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return College the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = College::findOne($id)) !== null) {
            Yii::$app->params['cTitle'] = $model->name;
            Yii::$app->params['cID'] = $model->id;
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionValidate($id = "")
    {
     if($id != "")
     {
        $model = $this->findModel($id);  
    }else{
        $model = new College();
    }

    if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }
}
}

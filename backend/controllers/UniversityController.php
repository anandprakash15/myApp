<?php

namespace backend\controllers;

use Yii;
use common\models\University;
use common\models\Courses;
use common\models\search\UniversitySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use common\models\UniversityCollegeCourse;
use common\models\search\UniversityCollegeCourseSearch;
use yii\db\Query;
use yii\bootstrap\ActiveForm;
use common\models\UniversityGallery;
use common\models\Approved;
use common\models\Accredite;
use common\models\Accredited;
use common\models\CourseDetails;
use common\models\search\FacilitySearch;
use common\models\Facility;
use common\models\search\ReviewSearch;
use common\models\Review;
use common\models\CollegeUniversityAdvpurpose;
use common\models\search\CollegeUniversityAdvpurposeSearch;
use common\models\CourseSpecialization;
use common\models\UniversityCollegeCourseSpecialization;
use common\models\Exam;
use common\models\Affiliate;
use common\models\FacilityGallery;
use common\models\UniversityBrochure;
use common\models\ApprovedGovernment;
use common\models\UniversityExam;
use yii\base\Model;


/**
 * UniversityController implements the CRUD actions for University model.
 */
class UniversityController extends Controller
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
     * Lists all University models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UniversitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionReview($id){
        $this->layout= "university";
        $university = $this->findModel($id);

        $searchModel = new ReviewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$university->id,'university');
        
        return $this->render('review', [
            'university' => $university,
            'dataProvider'=> $dataProvider,
            'searchModel'=> $searchModel
        ]);
    }

    public function actionReviewDetails($id,$rid = null)
    {
        $this->layout= "university";
        $university = $this->findModel($id);

        if (($model = Review::findOne(['id'=>$rid])) == null) {
            $model = new Review();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           \Yii::$app->getSession()->setFlash('success', 'Successful.');
           return $this->redirect(['review','id'=>$id]);
        }
        return $this->render('review-details', [
            'model' => $model,
            'university' => $university,
        ]);
    }


    public function actionCourseDetails($id)
    {
        $this->layout= "university";
        $universityandcourse = UniversityCollegeCourse::find()->joinWith(['course'])->where(['university_college_course.id'=>$id])->one();

        Yii::$app->params['uTitle'] = $universityandcourse->university->name;
        Yii::$app->params['uID'] = $universityandcourse->university->id;

        if (($model = CourseDetails::findOne(['uccID'=>$id])) == null) {
            $model = new CourseDetails();
        }
        $model->scenario = CourseDetails::SCENARIO_UNIVERSITY_COURSE;
        $model->uccID = $id;

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                \Yii::$app->getSession()->setFlash('success', 'Updated Successfully.');
            }else{
                //print_r($model);exit;
                \Yii::$app->getSession()->setFlash('error', 'Error Occurred.');
            }
            return $this->redirect(['courses','id'=>Yii::$app->params['uID']]);
        }


       return $this->render('course-details', [
            'model' => $model,
            'universityandcourse' => $universityandcourse
        ]);
    }

    public function actionAddSpecializations($id)
    {
        $this->layout= "university";
        $courseDetails = UniversityCollegeCourse::findOne($id);
        Yii::$app->params['uTitle'] = $courseDetails->university->name;
        Yii::$app->params['uID'] = $courseDetails->university->id;
        $specializations = ArrayHelper::map(CourseSpecialization::find()->joinWith(['specialization'])->where(['courseID'=>$courseDetails->course->id])->all(),'id','specialization.name');

        $ucsmodel = new UniversityCollegeCourseSpecialization();
        $ucsmodel->type = 1;
        $specializationModels = UniversityCollegeCourseSpecialization::find()->joinWith(['courseSpecialization'])->where(['coll_univID'=>$courseDetails->id,'type'=>1])->all();
        //print_r($specializationModels);exit;
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
                $nucsmodel->type = 1;
                $nucsmodel->status = 1;
                if(!$nucsmodel->save()){
                    //print_r($nucsmodel);exit;
                }    
            }

            if(!empty($deletedSpecializations))
            {
                UniversityCollegeCourseSpecialization::deleteAll(['coll_univID' => $courseDetails->id, 'course_specializationID' =>  array_values($deletedSpecializations)]);
            }

            \Yii::$app->getSession()->setFlash('success', 'Specializations successfully added in course '.$courseDetails->course->name.".");
            
            return $this->redirect(['add-specializations','id'=>$courseDetails->id]);
        }

        return $this->render('add-specializations', [
            'courseDetails' => $courseDetails,
            'specializations'=>$specializations,
            'ucsmodel' => $ucsmodel,
            'specializationModels' => $specializationModels
        ]);
    }


    public function actionAddExams($id)
    {
        $this->layout= "university";
        $courseDetails = UniversityCollegeCourse::findOne($id);
        Yii::$app->params['uTitle'] = $courseDetails->university->name;
        Yii::$app->params['uID'] = $courseDetails->university->id;
        $exams = ArrayHelper::map(Exam::find()->all(),'id','exam_name');
        
        $uexamModel = new UniversityExam();

        $oldExams = ArrayHelper::getColumn(UniversityExam::find()->where(['uccID'=>$courseDetails->id])->asArray()->all(),'examID');
        $uexamModel->examID = $oldExams;
        $uexamModel->uccID = $courseDetails->id;

        if ($uexamModel->load(Yii::$app->request->post())) {
            $newExams = [];
            if(!empty($uexamModel->examID)){
                $newExams = array_diff((array)$uexamModel['examID'], (array)$oldExams);
            }
            $deletedExams = array_diff((array)$oldExams,(array)$uexamModel['examID']);


            foreach ($newExams as $key => $exam) {
                $nuexamModel = new UniversityExam();
                $nuexamModel->examID = $exam;
                $nuexamModel->uccID = $courseDetails->id;
                if(!$nuexamModel->save()){
                    //print_r($nuexamModel);exit;
                }    
            }

            if(!empty($deletedExams))
            {
                UniversityExam::deleteAll(['uccID' => $courseDetails->id, 'examID' =>  array_values($deletedExams)]);
            }

            \Yii::$app->getSession()->setFlash('success', 'Exams successfully added in course '.$courseDetails->course->name.".");
            
            return $this->redirect(['add-exams','id'=>$courseDetails->id]);
        }

        return $this->render('add-exams', [
            'courseDetails' => $courseDetails,
            'exams'=>$exams,
            'uexamModel' => $uexamModel,
        ]);
    }

    public function actionAdvertiseMaterials($id)
    {
        $this->layout= "university";
        $university = $this->findModel($id);

        $searchModel = new CollegeUniversityAdvpurposeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$university->id,'university');
        
        return $this->render('advertise-materials', [
            'university' => $university,
            'dataProvider'=> $dataProvider,
            'searchModel'=> $searchModel,
        ]);
    }

    public function actionAdvertiseMaterialsDetails($id,$fid = null)
    {
        $this->layout= "university";
        $university = $this->findModel($id);

        if (($model = CollegeUniversityAdvpurpose::findOne(['id'=>$fid])) == null) {
            $model = new CollegeUniversityAdvpurpose();
            $model->scenario = "create";

        }
       
        $model->coll_univID  = $id;
        $model->type = 1;
        $imgPreview = [];
        $imgPreviewConfig = [];
        $oldFile = "";
        $uploadPath = Yii::$app->myhelper->getUploadPath(1,$university->id)."advertisement/";
        $fViewPath= Yii::$app->myhelper->getFileBasePath(1,$university->id)."advertisement/";
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
            \Yii::$app->getSession()->setFlash('success', 'Updated Successfully.');
            return $this->redirect(['advertise-materials','id'=>$university->id]);
        }


       return $this->render('advertise-materials-details', [
        'model' => $model,
        'university' => $university,
        'imgPreview'=>$imgPreview,
        'imgPreviewConfig'=> $imgPreviewConfig
    ]);
   }




    /**
     * Creates a new University model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new University();
        $universityBrochures = new UniversityBrochure();
        if ($model->load(Yii::$app->request->post())) {

            $model->approved_by = implode(",",(array) $model->approved_by);
            $model->accredited_by = implode(",",(array) $model->accredited_by);
            $model->affiliate_to = implode(",",(array) $model->affiliate_to);
            $model->approving_government_authority = implode(",",(array) $model->approving_government_authority);
            
            $bannerImg = UploadedFile::getInstance($model, 'bannerImg');
            if(!empty($bannerImg))
            {
                $model->bannerURL = "banner.".pathinfo($bannerImg->name, PATHINFO_EXTENSION);
            }

            
            
            $logoImg = UploadedFile::getInstance($model, 'logoImg');
            if(!empty($logoImg))
            {
                $model->logourl = "logo.".pathinfo($logoImg->name, PATHINFO_EXTENSION);
            }

            if($model->save()){

                $uploadPath = Yii::$app->myhelper->getUploadPath(1,$model->id);
                FileHelper::createDirectory($uploadPath,0775,true);
                if(!empty($bannerImg))
                {
                    $bannerImg->saveAs($uploadPath.$model->bannerURL);
                }

                if(!empty($logoImg))
                {
                    $logoImg->saveAs($uploadPath.$model->logourl);
                }

                $brochureFiles = UploadedFile::getInstances($universityBrochures, 'brochureFiles');
                $uploadPath =  Yii::$app->myhelper->getUBrochureUploadPath($model->id);
                FileHelper::createDirectory($uploadPath,0775,true);
                if(!empty($brochureFiles))
                {
                    foreach ($brochureFiles as $key => $brochureFile) {
                        $bFile = new UniversityBrochure();
                        $bFile->url = $brochureFile->name;
                        $bFile->universityID = $model->id;
                        if($bFile->save()){
                            $brochureFile->saveAs($uploadPath.$bFile->url);
                        }
                    }
                }

                \Yii::$app->getSession()->setFlash('success', 'Created Successfully.');
            }else{
                //print_r($model);exit;
                \Yii::$app->getSession()->setFlash('error', 'Error occured while creating.');
            }
            return $this->redirect(['view','id'=>$model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'approved_by' => [],
            'accredited_by' => [],
            'affiliate_to' => [],
            'approvedGovernment' => [],
            'universityBrochures'=>$universityBrochures,
            'brochureFilePreview' => [],
        ]);
    }

    /**
     * Updates an existing University model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->layout= "university";
        $model = $this->findModel($id);
        $oldbannerURL = $model->bannerURL;
        $oldlogoURL = $model->logourl;
        $approved_by = $accredited_by = $affiliate_to =  $approvedGovernment = [];
        $universityBrochures = new UniversityBrochure();
        $brochureFilePreview = UniversityBrochure::find()->where(['universityID'=>$model->id])->asArray()->all();
        
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

        if(!empty($model->approving_government_authority)){
           
            $approvedGovernment = ArrayHelper::map(ApprovedGovernment::find()->where(new \yii\db\Expression("id IN(".$model->approving_government_authority.")"))->asArray()->all(),'id','name');
            $model->approving_government_authority = explode(",",$model->approving_government_authority);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->approved_by = implode(",",(array) $model->approved_by);
            $model->accredited_by = implode(",",(array) $model->accredited_by);
            $model->affiliate_to = implode(",",(array) $model->affiliate_to);
            $model->approving_government_authority = implode(",",(array) $model->approving_government_authority);

            $uploadPath = Yii::$app->myhelper->getUploadPath(1,$model->id);
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
                
                if(!empty($logoImg))
                {
                    @unlink($uploadPath.$oldlogoURL);
                    $logoImg->saveAs($uploadPath.$model->logourl);
                }

                $brochureFiles = UploadedFile::getInstances($universityBrochures, 'brochureFiles');
                $uploadPath = Yii::$app->myhelper->getUBrochureUploadPath($model->id);;
                FileHelper::createDirectory($uploadPath,0775,true);
                if(!empty($brochureFiles))
                {
                    foreach ($brochureFiles as $key => $brochureFile) {
                        $bFile = new UniversityBrochure();
                        $bFile->url = $brochureFile->name;
                        $bFile->universityID = $model->id;
                        if($bFile->save()){
                            $brochureFile->saveAs($uploadPath.$bFile->url);
                        }
                    }
                }

                \Yii::$app->getSession()->setFlash('success', 'Updated Successfully.');
            }else{
                //print_r($model);exit;
                \Yii::$app->getSession()->setFlash('error', 'Error occured while update.');
            }
            return $this->redirect(['view','id'=>$model->id]);
        }


        return $this->render('update', [
            'model' => $model,
            'approved_by' => $approved_by,
            'accredited_by'=>$accredited_by,
            'affiliate_to' => $affiliate_to,
            'approvedGovernment' => $approvedGovernment,
            'universityBrochures'=>$universityBrochures,
            'brochureFilePreview'=>$brochureFilePreview
        ]);
    }

    /**
     * Displays a single University model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout= "university";
        $model = $this->findModel($id);
        $fBasePath = Yii::$app->myhelper->getFileBasePath(1,$model->id);

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
        $brochures = UniversityBrochure::find()->where(['universityID'=>$model->id])->all();
        $status = Yii::$app->myhelper->getActiveInactive();
        $universityType = Yii::$app->myhelper->getUniversitytype();
        $model->utype = isset($universityType[$model->utype])?$universityType[$model->utype]:'';
        $model->status = isset($status[$model->status])?$status[$model->status]:'';
         
        return $this->render('view', [
            'model' => $model,
            'fBasePath'=>$fBasePath,
            'brochures' => $brochures
        ]);
    }


    public function actionFacility($id)
    {
        $this->layout= "university";
        $university = $this->findModel($id);

        $searchModel = new FacilitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$university->id,'university');
        
        return $this->render('facility', [
            'university' => $university,
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
                $uplaodPath = Yii::$app->myhelper->getUploadPath(1,$id)."facility/";
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
        $this->layout= "university";
        $university = $this->findModel($id);
        $videos = $images =[];
        $fBasePath = Yii::$app->myhelper->getFileBasePath(1,$university->id)."facility/";
        if (($model = Facility::findOne(['id'=>$fid])) == null) {
            $model = new Facility();
        }else{
            $images = FacilityGallery::find()->where(['uc_type'=>1, 'type'=>1,'facilityID'=>$model->id])->all();
            $videos = FacilityGallery::find()->where(['uc_type'=>1, 'type'=>2,'facilityID'=>$model->id])->all();
        }
        //print_r($initialPreviewConfig);exit;
        
        $model->coll_univID  = $id;
        $model->type = 1;

        $facilityGallery = new FacilityGallery();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $uploadPath = Yii::$app->myhelper->getUploadPath(1,$id)."facility/";
            FileHelper::createDirectory($uploadPath,0775,true);

            $files = UploadedFile::getInstances($facilityGallery, 'imagevideo');
            //print_r($files);exit;
            foreach ($files as $key => $file) {
                $facilityGallery = new FacilityGallery();
                $facilityGallery->type = 2;
                if(strpos($file->type, "image/") !== false){
                    $facilityGallery->type = 1;
                }
                $facilityGallery->uc_type = 1;
                $facilityGallery->facilityID = $model->id;
                $facilityGallery->url = $file->name;
                $filePath = $uploadPath.$facilityGallery->url;
                if($file->saveAs($filePath)){
                    if($facilityGallery->save()){
                        if($facilityGallery->type == 2){
                            $thumbPath = $uploadPath.pathinfo($file->name,PATHINFO_FILENAME)."-thumb.png";
                            Yii::$app->myhelper->videoThumb($filePath,$thumbPath);
                        }
                    }
                }
            }

            \Yii::$app->getSession()->setFlash('success', 'Facility Successfully Updated.');
            return $this->redirect(['facility-details','id'=>$university->id,'fid'=>$model->id]);
        }

        // /print_r($fileList);exit;
        return $this->render('facility-details', [
            'model' => $model,
            'university' => $university,
            'facilityGallery'=>$facilityGallery,
            'fBasePath'=>$fBasePath,
            'images'=>$images,
            'videos' => $videos
        ]);
    }


    public function actionGallery($id,$type){
        $this->layout= "university";
        $university = $this->findModel($id);

        $uID = Yii::$app->myhelper->getEncryptID($id);
        $fileType = "image";

        $fileList = UniversityGallery::find()->where(['universityID'=>$university->id,'type'=>$type])->all();
        $allowedFileExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if($type == 2){
            $fileType = "video";
            $allowedFileExtensions = ['mp4']; //'avi','mkv','mts','mpv','flv'
        }
        $fBasePath = Yii::$app->myhelper->getFileBasePath(1,$university->id,$type);

        return $this->render('gallery', [
            'university' => $university,
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
            $uploadPath = Yii::$app->myhelper->getUploadPath(1,$id,$type);
            
            $successfiles = [];
            $errorfiles = [];
            FileHelper::createDirectory($uploadPath,0775,true);
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $files = UploadedFile::getInstancesByName('ufiles');

            foreach ($files as $key => $file) {
                $model = new UniversityGallery();
                $model->type = $type;
                $model->universityID = $id;
                $model->url = $file->name;
                $model->status = 1;
                $filePath = $uploadPath.$model->url;
                if($file->saveAs($filePath)){
                    if($model->save()){
                        array_push($successfiles, $model->url);
                        if($type == 2){
                            $thumbPath = $uploadPath.pathinfo($file->name, PATHINFO_FILENAME )."-thumb.png";
                            Yii::$app->myhelper->videoThumb($filePath,$thumbPath);
                        }
                    }
                }else{
                    array_push($errorfiles, $model->url);
                }   
            }
            $success = $errors =  '';
            if(!empty($successfiles)){
                $success =  "Successfully uploaded Files- ".implode(", ", $successfiles);
            }
            if(!empty($errorfiles)){
                $errors =  "Error Files- ".implode(", ", $errorfiles);
            }

            return ['success'=>$success, 'errors'=>$errors];
        }
    }


    public function actionDeleteFile($id,$property){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model = University::findOne($id);
        $filename = $model->$property;
        $model->$property = "";
        if($model->save()){
            $uploadPath = Yii::$app->myhelper->getUploadPath(1,$id);
            @unlink($uploadPath.$filename);
            return ['success'=>false];
        }
    }

    public function actionDeleteBrochure(){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        if(!empty($id))
        {
            $model = UniversityBrochure::findOne($id);
            if($model->delete())
            {
                $uploadPath = Yii::$app->myhelper->getUBrochureUploadPath($model->universityID);
                @unlink($uploadPath.$model->url);
                return ['success'=>true];
            }  
        }
        return ['error'=>true];
    }

    public function actionDeleteGalleryFile($id){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $file = UniversityGallery::findOne($id);
        if(!empty($file))
        {

            if($file->delete()){
                $uploadPath = Yii::$app->myhelper->getUploadPath(1,$file->universityID,$file->type);
                @unlink($uploadPath.$file->url);
                if($file->type == 2){
                    @unlink($uplaodPath.pathinfo($file->url, PATHINFO_FILENAME)."-thumb.png");
                }
                return ['success'=>true];
            }
        }
        return ['error'=>true,'msg'=>'Error occured while deleting the file.'];
    }


    public function actionCourses($id){
        $this->layout= "university";
        $university = $this->findModel($id);

        $searchModel = new UniversityCollegeCourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$university->id,'university');
        
        return $this->render('courses', [
            'university' => $university,
            'dataProvider'=> $dataProvider,
            'searchModel'=> $searchModel,
        ]);
    }


    public function actionAddCourses($id){
        $this->layout= "university";
        $university = $this->findModel($id);
        $courses = ArrayHelper::map(Courses::find()->where(['status'=>1])->all(),'id','name');
        $ucmodel = new UniversityCollegeCourse();
        $ucmodel->scenario = UniversityCollegeCourse::SCENARIO_UC_CREATE;


        $oldCourses = ArrayHelper::getColumn(UniversityCollegeCourse::find()->where(['universityID'=>$university->id])->asArray()->all(),'courseID');


        
        $ucmodel->courseID = $oldCourses;

        $ucmodel->universityID = $university->id;

        if ($ucmodel->load(Yii::$app->request->post())) {

            $newCourse = array_diff((array)$ucmodel['courseID'], (array)$oldCourses);

            $deletedCourse = array_diff((array)$oldCourses,(array)$ucmodel['courseID']);    
            foreach ($newCourse as $key => $courseID) {
                $nucmodel = new UniversityCollegeCourse();
                $nucmodel->universityID = $university->id;
                $nucmodel->courseID = $courseID;
                $nucmodel->status = 1;
                if(!$nucmodel->save()){
                    //print_r($nucmodel);exit;
                }    
            }

            if(!empty($deletedCourse))
            {
                UniversityCollegeCourse::deleteAll(['universityID' => $university->id, 'courseID' =>  array_values($deletedCourse)]);
            }

            \Yii::$app->getSession()->setFlash('success', 'Courses successfully added in university '.$university->name.".");
            
            return $this->redirect(['courses','id'=>$university->id]);
        }

        
        return $this->render('add_courses', [
            'university' => $university,
            'courses'=>$courses,
            'ucmodel' => $ucmodel,
        ]);
    }

    /**
     * Deletes an existing University model.
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
     * Finds the University model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return University the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = University::findOne($id)) !== null) {
            Yii::$app->params['uTitle'] = $model->name;
            Yii::$app->params['uID'] = $model->id;
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUniversityList($q = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select(["id", new \yii\db\Expression("name AS text")])
            ->from('university')
            ->where(['like', 'name', $q])
            ->andWhere(['status'=>1])
            ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        return $out;
    }


    public function actionUniversityCourses($q = null,$affiliation_type,$universityID="") {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select(["courses.id", new \yii\db\Expression("courses.name AS text"),'programID'])
            ->from('courses')
            ->where(['like', 'name', $q]);
            if($affiliation_type == 2){
                $query->leftJoin("university_college_course","courses.id = university_college_course.courseID ")
                ->andWhere(['university_college_course.universityID'=>$universityID]);
            }else{
                $query->andWhere(['courses.courseType'=>1]);
            }

            
            
            $query->andWhere(['courses.status'=>1])
            ->groupBy(['courses.id'])
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
        $model = new University();
    }

    if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }
}

}

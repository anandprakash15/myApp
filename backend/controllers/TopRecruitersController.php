<?php

namespace backend\controllers;

use Yii;
use common\models\TopRecruiters;
use common\models\search\TopRecruitersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\web\Response;

/**
 * TopRecruitersController implements the CRUD actions for TopRecruiters model.
 */
class TopRecruitersController extends Controller
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
     * Lists all TopRecruiters models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TopRecruitersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TopRecruiters model.
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
     * Creates a new TopRecruiters model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TopRecruiters();
        if ($model->load(Yii::$app->request->post())) {
            $logoImg = UploadedFile::getInstance($model, 'logoImg');
            if(!empty($logoImg))
            {
                $model->logo = $logoImg->name;
            }

            if($model->save()){
                $uploadPath = Yii::$app->myhelper->trLogoBaseUrl;
                FileHelper::createDirectory($uploadPath,0775,true);
                if(!empty($logoImg))
                {
                    $logoImg->saveAs($uploadPath.$model->logo);
                }
                \Yii::$app->getSession()->setFlash('success', 'Created Successfully.');
            }else{
                \Yii::$app->getSession()->setFlash('error', 'Error occurred while creating.');
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TopRecruiters model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldFile = $model->logo;
        if ($model->load(Yii::$app->request->post())) {
            $logoImg = UploadedFile::getInstance($model, 'logoImg');
            if(!empty($logoImg))
            {
                $model->logo = $logoImg->name;
            }

            if($model->save()){
                $uploadPath = Yii::$app->myhelper->trLogoBaseUrl;
                
                FileHelper::createDirectory($uploadPath,0775,true);
                if(!empty($logoImg))
                {
                    if(!empty($oldFile)){
                        @unlink($uploadPath.$oldFile);
                    }
                    $logoImg->saveAs($uploadPath.$model->logo);
                }
                \Yii::$app->getSession()->setFlash('success', 'Updated Successfully.');
            }else{
                \Yii::$app->getSession()->setFlash('error', 'Error occurred while creating.');
            }
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDeleteFile($id){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if(!empty($model))
        {
            $uploadPath = Yii::$app->myhelper->trLogoBaseUrl;
            @unlink($uploadPath.$model->logo);
            $model->logo = '';
            if($model->save()){
                return ['success'=>true];
            }
        }
        return ['error'=>'Error occurred while deleting file.'];
    }

    /**
     * Deletes an existing TopRecruiters model.
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
     * Finds the TopRecruiters model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TopRecruiters the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TopRecruiters::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

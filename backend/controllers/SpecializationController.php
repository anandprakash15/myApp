<?php

namespace backend\controllers;

use Yii;
use common\models\Specialization;
use common\models\search\SpecializationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use common\models\TopRecruiters;
use common\models\SpecializationRecruiters;

/**
 * SpecializationController implements the CRUD actions for Specialization model.
 */
class SpecializationController extends Controller
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
     * Lists all Specialization models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SpecializationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Specialization model.
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
     * Creates a new Specialization model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Specialization();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', 'Created Successfully.');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Specialization model.
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
     * Deletes an existing Specialization model.
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


    public function actionSpecializationList($q = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select(["id", new \yii\db\Expression("name AS text")])
            ->from('specialization')
            ->where(['like', 'name', $q])
            ->andWhere(['status'=>1])
            ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        return $out;
    }

    public function actionAddRecruiters($id){
        $specialization = $this->findModel($id);
        $recruiters = ArrayHelper::map(TopRecruiters::find()->where(['status'=>1])->all(),'id','short_name');
        $csmodel = new SpecializationRecruiters();


        $oldRecruiters = ArrayHelper::getColumn(SpecializationRecruiters::find()->where(['specializationID'=>$specialization->id])->asArray()->all(),'topRecruitersID');


        
        $csmodel->topRecruitersID = $oldRecruiters;

        $csmodel->specializationID = $specialization->id;

        if ($csmodel->load(Yii::$app->request->post())) {
            $newRecruiters = [];
            if(!empty($csmodel->topRecruitersID)){
               $newRecruiters = array_diff((array)$csmodel['topRecruitersID'], (array)$oldRecruiters); 
            }
            
            $deletedSpecializations = array_diff((array)$oldRecruiters,(array)$csmodel['topRecruitersID']);

            foreach ($newRecruiters as $key => $recruiter) {
                $ncsmodel = new SpecializationRecruiters();
                $ncsmodel->specializationID = $specialization->id;
                $ncsmodel->topRecruitersID = $recruiter;
                if(!$ncsmodel->save()){
                    //print_r($nucmodel);exit;
                }    
            }

            if(!empty($deletedSpecializations))
            {
                SpecializationRecruiters::deleteAll(['specializationID' => $specialization->id, 'topRecruitersID' =>  array_values($deletedSpecializations)]);
            }

            \Yii::$app->getSession()->setFlash('success', 'Recruiters successfully added in specialization '.$specialization->name.".");
            
            return $this->redirect(['add-recruiters','id'=>$specialization->id]);
        }

        
        return $this->render('add_recruiters', [
            'specialization' => $specialization,
            'recruiters'=>$recruiters,
            'csmodel' => $csmodel,
        ]);
    }

    /**
     * Finds the Specialization model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Specialization the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Specialization::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

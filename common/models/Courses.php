<?php

namespace common\models; 

use Yii; 

/** 
 * This is the model class for table "courses". 
 * 
 * @property int $id
 * @property int $programID
 * @property string $name
 * @property string $short_name
 * @property string $code
 * @property int $duration
 * @property string $required_skillset
 * @property int $medium_of_teaching
 * @property string $course_high_lights
 * @property int $sortno
 * @property int $certification_type
 * @property string $createdDate
 * @property string $updatedDate
 * @property int $status
 * @property int $createdBy
 * @property int $updatedBy
 * @property int $full_part_time 1-fulltime, 2-parttime
 * @property int $courseType (autonomas, university)
 * @property int $qualification_type
 * @property CourseSpecialization[] $courseSpecializations
 * @property Program $program
 * @property User $createdBy0
 * @property User $updatedBy0
 * @property UniversityCollegeCourse[] $universityCollegeCourses
 */

class Courses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'courses';
    }
    

    /**
     * @inheritdoc
     */

    public function rules() 
    { 
        return [
            [['programID', 'name', 'short_name', 'status', 'qualification_type', 'courseType'], 'required'],
            [['programID', 'duration', 'medium_of_teaching', 'sortno', 'certification_type', 'status', 'createdBy', 'updatedBy', 'full_part_time', 'courseType'], 'integer'],
            [['required_skillset', 'course_high_lights'], 'string'],
            [['createdDate', 'updatedDate'], 'safe'],
            [['name'], 'string', 'max' => 300],
            [['short_name'], 'string', 'max' => 100],
            [['programID'], 'exist', 'skipOnError' => true, 'targetClass' => Program::className(), 'targetAttribute' => ['programID' => 'id']],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['createdBy' => 'id']],
            [['updatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updatedBy' => 'id']],
            ['short_name','validateShortName'],
            ['code', 'codeunique'],
        ]; 
    } 

    public function validateShortName($attribute, $params, $validator)
    {
        $query = Courses::find()->where(['programID'=>$this->programID,'LOWER(short_name)'=>strtolower($this->short_name)]);
        
        if(!$this->isNewRecord)
        {
            $query->andWhere(['<>','id', $this->id]);
        }
        $check = $query->one();
        if(!empty($check)){
            $this->addError($attribute, $this->short_name.' short name has already been taken.');
        }
    }

    public function codeunique($attribute,$params)
    {
        $check = '';
        if(!$this->isNewRecord){
            $id = $this->id;
            $check = Courses::find()->where(['code'=>$this->code])->andWhere(['<>','id',$id])->one();
        }else{
            $check = Courses::find()->where(['code'=>$this->code])->one();
        }
        if(!empty($check)){
            $this->addError($attribute, $this->code.' This code has already been taken');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() 
    { 
        return [ 
            'id' => 'ID',
            'programID' => 'Program',
            'name' => 'Name',
            'short_name' => 'Short Name',
            'code' => 'Code',
            'duration' => 'Course Duration',
            'required_skillset' => 'Required Skillset',
            'medium_of_teaching' => 'Medium of Teaching',
            'course_high_lights' => 'Course High Lights',
            'sortno' => 'Sortno',
            'certification_type' => 'Certification Type',
            'createdDate' => 'Created Date',
            'updatedDate' => 'Updated Date',
            'status' => 'Status',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
            'full_part_time' => 'Course Type',
            'qualification_type' => 'Qualification Type',
            'courseType' => 'Affiliation Type',
        ]; 
    } 

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $maxcode = Courses::find()->max('code');
                if(empty($maxcode)){
                    $maxcode = 0;
                }
                $this->code = $maxcode + 1; 
                $this->createdBy = \Yii::$app->user->identity->id;
                $this->createdDate = date('Y-m-d H:i:s');
            }
            $this->updatedBy = \Yii::$app->user->identity->id;
            return true;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgram()
    {
        return $this->hasOne(Program::className(), ['id' => 'programID']);
    }

    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getCourseSpecializations() 
    { 
        return $this->hasMany(CourseSpecialization::className(), ['courseID' => 'id']);
    } 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy0()
    {
        return $this->hasOne(User::className(), ['id' => 'createdBy']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy0()
    {
        return $this->hasOne(User::className(), ['id' => 'updatedBy']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniversityCourses()
    {
        return $this->hasMany(UniversityCourse::className(), ['courseID' => 'id']);
    }
}

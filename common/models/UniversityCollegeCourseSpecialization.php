<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "university_college_course_specialization".
 *
 * @property int $id
 * @property int $type 1-unvesity, 2-college
 * @property int $coll_univID
 * @property int $course_specializationID
 * @property int $intake
 * @property string $createdDate
 * @property string $updatedDate
 * @property int $createdBy
 * @property int $updatedBy
 * @property int $status
 */
class UniversityCollegeCourseSpecialization extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'university_college_course_specialization';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'coll_univID', 'course_specializationID', 'status'], 'required'],
            [['type', 'coll_univID', 'course_specializationID','intake','createdBy', 'updatedBy', 'status'], 'integer'],
            [['createdDate', 'updatedDate'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'coll_univID' => 'Coll Univ ID',
            'course_specializationID' => 'Course Specialization ID',
            'intake' => 'Intake',
            'createdDate' => 'Created Date',
            'updatedDate' => 'Updated Date',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
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
    public function getCourseSpecialization()
    {
        return $this->hasOne(CourseSpecialization::className(), ['id' => 'course_specializationID'])->joinWith(['specialization']);
    }

}

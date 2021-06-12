<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "university_exam".
 *
 * @property int $id
 * @property int $uccID
 * @property int $examID
 * @property string $createdDate
 * @property int $createdBy
 * @property string $updatedDate
 * @property int $updatedBy
 *
 * @property UniversityCollegeCourse $ucc
 * @property Exam $exam
 */
class UniversityExam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'university_exam';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uccID'], 'required'],
            [['uccID', 'examID', 'createdBy', 'updatedBy'], 'integer'],
            [['createdDate', 'updatedDate'], 'safe'],
            [['uccID'], 'exist', 'skipOnError' => true, 'targetClass' => UniversityCollegeCourse::className(), 'targetAttribute' => ['uccID' => 'id']],
            [['examID'], 'exist', 'skipOnError' => true, 'targetClass' => Exam::className(), 'targetAttribute' => ['examID' => 'id']],
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uccID' => 'Ucc ID',
            'examID' => 'Exam',
            'createdDate' => 'Created Date',
            'createdBy' => 'Created By',
            'updatedDate' => 'Updated Date',
            'updatedBy' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUcc()
    {
        return $this->hasOne(UniversityCollegeCourse::className(), ['id' => 'uccID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExam()
    {
        return $this->hasOne(Exam::className(), ['id' => 'examID']);
    }
}

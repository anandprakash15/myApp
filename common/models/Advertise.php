<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "advertise".
 *
 * @property int $id
 * @property int $type 1-unversity, 2-college
 * @property int $coll_univID
 * @property int $college_university_advpurposeID
 * @property int $programID
 * @property int $courseID
 * @property int $gtype
 * @property int $priority
 * @property string $fromDate
 * @property string $toDate
 * @property int $cityID
 * @property int $stateID
 * @property int $countryID
 * @property string $description
 * @property string $createdDate
 * @property string $updatedDate
 * @property int $status
 * @property int $createdBy
 * @property int $updatedBy
 *
 * @property User $createdBy0
 * @property User $updatedBy0
 */
class Advertise extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advertise';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'coll_univID', 'college_university_advpurposeID','status', 'fromDate', 'toDate'], 'required'],
            [['type', 'coll_univID', 'college_university_advpurposeID', 'programID', 'courseID', 'cityID', 'stateID', 'countryID', 'status', 'createdBy', 'updatedBy','priority','gtype'], 'integer'],
            [['fromDate', 'toDate', 'createdDate', 'updatedDate'], 'safe'],
            [['description'], 'string'],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['createdBy' => 'id']],
            [['updatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updatedBy' => 'id']],
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
            'coll_univID' => 'College/University',
            'college_university_advpurposeID' => 'College University Advpurpose',
            'programID' => 'Program',
            'courseID' => 'Course',
            'fromDate' => 'From Date',
            'toDate' => 'To Date',
            'cityID' => 'City',
            'stateID' => 'State',
            'countryID' => 'Country',
            'description' => 'Description',
            'createdDate' => 'Created Date',
            'updatedDate' => 'Updated Date',
            'status' => 'Status',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
            'gtype' => 'Type',
            'priority' => 'Priority',
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

    public function getCollege()
    {
        return $this->hasOne(College::className(), ['id' => 'coll_univID']);
    }

    public function getUniversity()
    {
        return $this->hasOne(University::className(), ['id' => 'coll_univID']);
    }
}

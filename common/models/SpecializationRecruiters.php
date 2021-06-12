<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "specialization_recruiters".
 *
 * @property int $id
 * @property int $specializationID
 * @property int $topRecruitersID
 * @property string $createdDate
 * @property int $createdBy
 * @property string $updatedDate
 * @property int $updatedBy
 */
class SpecializationRecruiters extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'specialization_recruiters';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['specializationID'], 'required'],
            [['specializationID', 'topRecruitersID', 'createdBy', 'updatedBy'], 'integer'],
            [['createdDate', 'updatedDate'], 'safe'],
            [['specializationID'], 'exist', 'skipOnError' => true, 'targetClass' => Specialization::className(), 'targetAttribute' => ['specializationID' => 'id']],
            [['topRecruitersID'], 'exist', 'skipOnError' => true, 'targetClass' => TopRecruiters::className(), 'targetAttribute' => ['topRecruitersID' => 'id']],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['createdBy' => 'id']],
            [['updatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updatedBy' => 'id']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'specializationID' => 'Specialization',
            'topRecruitersID' => 'Top Recruiters',
            'createdDate' => 'Created Date',
            'createdBy' => 'Created By',
            'updatedDate' => 'Updated Date',
            'updatedBy' => 'Updated By',
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
    public function getSpecialization()
    {
        return $this->hasOne(Specialization::className(), ['id' => 'specializationID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopRecruiters()
    {
        return $this->hasOne(TopRecruiters::className(), ['id' => 'topRecruitersID']);
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
}

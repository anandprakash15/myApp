<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "university_type".
 *
 * @property int $id
 * @property int $universityID
 * @property int $type
 * @property string $updatedDate
 * @property int $createdBy
 * @property int $updatedBy
 *
 * @property University $university
 * @property User $createdBy0
 * @property User $updatedBy0
 */
class UniversityType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'university_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['universityID', 'type', 'createdBy', 'updatedBy'], 'required'],
            [['universityID', 'type', 'createdBy', 'updatedBy'], 'integer'],
            [['updatedDate'], 'safe'],
            [['universityID'], 'exist', 'skipOnError' => true, 'targetClass' => University::className(), 'targetAttribute' => ['universityID' => 'id']],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['createdBy' => 'id']],
            [['updatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updatedBy' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'universityID' => 'University ID',
            'type' => 'Type',
            'updatedDate' => 'Updated Date',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniversity()
    {
        return $this->hasOne(University::className(), ['id' => 'universityID']);
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

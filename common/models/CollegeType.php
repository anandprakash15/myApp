<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "college_type".
 *
 * @property int $id
 * @property int $collegeID
 * @property int $type private, autonomus etc
 * @property string $updatedDate
 * @property int $createdBy
 * @property int $updatedBy
 *
 * @property College $college
 * @property User $createdBy0
 * @property User $updatedBy0
 */
class CollegeType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'college_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['collegeID', 'type', 'createdBy', 'updatedBy'], 'required'],
            [['collegeID', 'type', 'createdBy', 'updatedBy'], 'integer'],
            [['updatedDate'], 'safe'],
            [['collegeID'], 'exist', 'skipOnError' => true, 'targetClass' => College::className(), 'targetAttribute' => ['collegeID' => 'id']],
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
            'collegeID' => 'College ID',
            'type' => 'Type',
            'updatedDate' => 'Updated Date',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollege()
    {
        return $this->hasOne(College::className(), ['id' => 'collegeID']);
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

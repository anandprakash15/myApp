<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property int $type 1-unvesity, 2-college
 * @property int $coll_univID
 * @property int $courseID
 * @property double $placement_star
 * @property string $placement_review
 * @property double $infrastructure_star
 * @property string $infrastructure_review
 * @property double $fcc_star
 * @property string $fcc_review
 * @property double $ccl_star
 * @property string $cct_review
 * @property double $wtd_star
 * @property string $wtd_review
 * @property double $other_star
 * @property string $other_review
 * @property string $createdDate
 * @property string $updatedDate
 * @property int $status
 * @property int $createdBy
 * @property int $updatedBy
 *
 * @property User $createdBy0
 * @property User $updatedBy0
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'coll_univID', 'courseID', 'createdDate', 'status', 'createdBy', 'updatedBy'], 'required'],
            [['type', 'coll_univID', 'courseID', 'status', 'createdBy', 'updatedBy'], 'integer'],
            [['placement_star', 'infrastructure_star', 'fcc_star', 'ccl_star', 'wtd_star', 'other_star'], 'number'],
            [['placement_review', 'infrastructure_review', 'fcc_review', 'cct_review', 'wtd_review', 'other_review'], 'string'],
            [['createdDate', 'updatedDate'], 'safe'],
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
            'coll_univID' => 'Coll Univ ID',
            'courseID' => 'Course ID',
            'placement_star' => 'Placement Star',
            'placement_review' => 'Placement Review',
            'infrastructure_star' => 'Infrastructure Star',
            'infrastructure_review' => 'Infrastructure Review',
            'fcc_star' => 'Fcc Star',
            'fcc_review' => 'Fcc Review',
            'ccl_star' => 'Ccl Star',
            'cct_review' => 'Cct Review',
            'wtd_star' => 'Wtd Star',
            'wtd_review' => 'Wtd Review',
            'other_star' => 'Other Star',
            'other_review' => 'Other Review',
            'createdDate' => 'Created Date',
            'updatedDate' => 'Updated Date',
            'status' => 'Status',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
        ];
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
    public function getCourse()
    {
        return $this->hasOne(Courses::className(), ['id' => 'courseID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy0()
    {
        return $this->hasOne(User::className(), ['id' => 'updatedBy']);
    }
}

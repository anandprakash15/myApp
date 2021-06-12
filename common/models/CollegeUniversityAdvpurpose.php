<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "college_university_advpurpose".
 *
 * @property int $id
 * @property int $type 1-unvesity, 2-college
 * @property int $coll_univID
 * @property int $gtype 1-top,2-bottom,3-left, 4-right, 5-center, 6-video
 * @property string $createdDate
 * @property string $updatedDate
 * @property string $url
 * @property int $status
 * @property int $createdBy
 * @property int $updatedBy
 *
 * @property User $createdBy0
 * @property User $updatedBy0
 */
class CollegeUniversityAdvpurpose extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $urlImage;
    public static function tableName()
    {
        return 'college_university_advpurpose';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'coll_univID', 'gtype', 'status'], 'required'],
            [['urlImage'],'required','on'=>['create']],
            [['type', 'coll_univID', 'gtype', 'status', 'createdBy', 'updatedBy'], 'integer'],
            [['createdDate', 'updatedDate','url','urlImage'], 'safe'],
            ['urlImage', 'file', 'extensions'=>'jpg, jpeg, png', 'when' => function ($model) {
                return $model->gtype != 6;
                },'whenClient' => "function (attribute, value) {
                    console.log($('#collegeuniversityadvpurpose-gtype').val());
                    return $('#collegeuniversityadvpurpose-gtype').val() != 6;
                }"
            ],
            ['urlImage', 'file', 'extensions'=>'mp4, avi, mkv', 'when' => function ($model) {
                return $model->gtype == 6;
                },'whenClient' => "function (attribute, value) {
                    console.log($('#collegeuniversityadvpurpose-gtype').val());
                    return $('#collegeuniversityadvpurpose-gtype').val() == 6;
                }"
            ],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['createdBy' => 'id']],
            [['updatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updatedBy' => 'id']],
            
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'coll_univID' => 'Coll Univ ID',
            'gtype' => 'Type',
            'createdDate' => 'Created Date',
            'updatedDate' => 'Updated Date',
            'status' => 'Status',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
            'urlImage' => 'Select File',

            
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
    public function getUpdatedBy0()
    {
        return $this->hasOne(User::className(), ['id' => 'updatedBy']);
    }
}

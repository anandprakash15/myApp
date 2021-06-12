<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "seo".
 *
 * @property int $id
 * @property int $type 1-unvesity, 2-college, 3-course
 * @property int $coll_course_univID
 * @property string $keywords
 * @property string $description
 * @property string $title
 * @property string $createdDate
 * @property string $updatedDate
 * @property int $status
 * @property int $createdBy
 *
 * @property Seo $createdBy0
 * @property Seo[] $seos
 */
class Seo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'coll_course_univID', 'keywords', 'description', 'title', 'createdDate', 'status', 'createdBy'], 'required'],
            [['type', 'coll_course_univID', 'status', 'createdBy'], 'integer'],
            [['keywords', 'description', 'title'], 'string'],
            [['createdDate', 'updatedDate'], 'safe'],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => Seo::className(), 'targetAttribute' => ['createdBy' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'coll_course_univID' => 'Coll Course Univ ID',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'title' => 'Title',
            'createdDate' => 'Created Date',
            'updatedDate' => 'Updated Date',
            'status' => 'Status',
            'createdBy' => 'Created By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy0()
    {
        return $this->hasOne(Seo::className(), ['id' => 'createdBy']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeos()
    {
        return $this->hasMany(Seo::className(), ['createdBy' => 'id']);
    }
}

<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news_artical".
 *
 * @property int $id
 * @property int $natype 1-news, 2-artical
 * @property int $type 1-unversity, 2-college
 * @property int $coll_univ_examID
 * @property int $programID
 * @property int $courseID
 * @property string $title
 * @property string $description
 * @property int $national_international 1-national, 2-international
 * @property string $startDate
 * @property string $endDate
 * @property string $createdDate
 * @property string $updatedDate
 * @property int $status
 * @property int $createdBy
 * @property int $updatedBy
 * @property int $countryID
 * @property int $cityID    
 * @property int $stateID


 *
 * @property User $createdBy0
 * @property User $updatedBy0
 */
class NewsArtical extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_artical';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['natype', 'type', 'title', 'description', 'national_international','startDate', 'endDate'], 'required'],
            [['natype', 'type', 'coll_univ_examID', 'programID', 'courseID', 'national_international', 'status', 'createdBy', 'updatedBy','countryID','cityID','stateID'], 'integer'],
            [['title', 'description'], 'string'],
            [['startDate', 'endDate', 'createdDate', 'updatedDate'], 'safe'],
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'natype' => 'Natype',
            'type' => 'Type',
            'coll_univ_examID' => 'Coll Univ Exam ID',
            'programID' => 'Program ID',
            'courseID' => 'Course ID',
            'title' => 'Title',
            'description' => 'Description',
            'national_international' => 'National International',
            'startDate' => 'Start Date',
            'endDate' => 'End Date',
            'createdDate' => 'Created Date',
            'updatedDate' => 'Updated Date',
            'status' => 'Status',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
            'countryID' => 'Country',
            'cityID' => 'City',
            'stateID' => 'State',
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

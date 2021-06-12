<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "top_recruiters".
 *
 * @property int $id
 * @property int $industry_sectorID
 * @property string $company
 * @property string $short_name
 * @property string $logo
 * @property string $description
 * @property int $status
 * @property int $createdBy
 * @property int $updatedBy
 * @property string $createdDate
 * @property string $updatedDate
 */
class TopRecruiters extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $logoImg;
    public static function tableName()
    {
        return 'top_recruiters';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['industry_sectorID', 'status', ], 'required'],
            [['industry_sectorID', 'status', 'createdBy', 'updatedBy'], 'integer'],
            [['description'], 'string'],
            [['logoImg'], 'file', 'extensions'=>'jpg, jpeg, png'],
            [['createdDate', 'updatedDate','createdBy', 'updatedBy'], 'safe'],
            [['company', 'logo'], 'string', 'max' => 500],
            [['short_name'], 'string', 'max' => 100],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['createdBy' => 'id']],
            [['updatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updatedBy' => 'id']],
            [['industry_sectorID'], 'exist', 'skipOnError' => true, 'targetClass' => IndustrySector::className(), 'targetAttribute' => ['industry_sectorID' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'logoImg' => 'Logo',
            'industry_sectorID' => 'Industry Sector',
            'company' => 'Company',
            'short_name' => 'Short Name',
            'logo' => 'Logo',
            'description' => 'Description',
            'status' => 'Status',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
            'createdDate' => 'Created Date',
            'updatedDate' => 'Updated Date',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustrySector()
    {
        return $this->hasOne(IndustrySector::className(), ['id' => 'industry_sectorID']);
    }
}

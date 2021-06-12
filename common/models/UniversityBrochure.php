<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "university_brochure".
 *
 * @property int $id
 * @property int $universityID
 * @property string $url
 * @property int $createdBy
 * @property int $updatedBy
 * @property string $createdDate
 * @property string $updatedDate
 */
class UniversityBrochure extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $brochureFiles;
    public static function tableName()
    {
        return 'university_brochure';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['universityID', 'url'], 'required'],
            [['brochureFiles'], 'file','extensions'=>'pdf, doc, docx', 'maxFiles' => 10],
            [['universityID', 'createdBy', 'updatedBy'], 'integer'],
            [['createdDate', 'updatedDate'], 'safe'],
            [['url'], 'string', 'max' => 500],
            [['universityID'], 'exist', 'skipOnError' => true, 'targetClass' => University::className(), 'targetAttribute' => ['universityID' => 'id']],
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
            'universityID' => 'University ID',
            'url' => 'Url',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
            'createdDate' => 'Created Date',
            'updatedDate' => 'Updated Date',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniversity()
    {
        return $this->hasOne(University::className(), ['id' => 'universityID']);
    }
}

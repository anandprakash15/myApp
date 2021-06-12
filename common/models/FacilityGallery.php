<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "facility_gallery".
 *
 * @property int $id
 * @property int $uc_type 1-university, 2-college
 * @property int $type 1-image, 2-video
 * @property int $facilityID
 * @property string $url
 * @property string $createdDate
 * @property string $updatedDate
 * @property int $createdBy
 * @property int $updatedBy
 */
class FacilityGallery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $imagevideo;
    public static function tableName()
    {
        return 'facility_gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uc_type', 'type', 'facilityID', 'url'], 'required'],
            [['uc_type', 'type', 'facilityID', 'createdBy', 'updatedBy'], 'integer'],
            [['createdDate', 'updatedDate'], 'safe'],
            [['imagevideo'], 'file','skipOnEmpty' => true, 'maxFiles' => 20, 'extensions' => 'jpg, jpeg, png, gif, mp4'],
            [['url'], 'string', 'max' => 500],
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
            'uc_type' => 'Uc Type',
            'type' => 'Type',
            'facilityID' => "Facility",
            'url' => 'Url',
            'imagevideo'=> 'Image/Video',
            'createdDate' => 'Created Date',
            'updatedDate' => 'Updated Date',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
        ];
    }
}

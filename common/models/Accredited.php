<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "accredited".
 *
 * @property int $id
 * @property string $name
 * @property string $shortname
 * @property string $description
 * @property int $country
 * @property string $createdDate
 * @property int $createdBy
 * @property string $updatedDate
 * @property int $updatedBy
 * @property int $status
 */
class Accredited extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accredited';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'shortname','status', 'countryID'], 'required'],
            [['createdDate', 'updatedDate', 'description'], 'safe'],
            [['createdBy', 'updatedBy', 'status', 'countryID'], 'integer'],
            [['name'], 'string', 'max' => 200],
            [['shortname'], 'string', 'max' => 30],
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
            'name' => 'Name',
            'shortname' => 'Short Name',
            'description' => 'Description',
            'countryID' => 'Country',
            'createdDate' => 'Created Date',
            'createdBy' => 'Created By',
            'updatedDate' => 'Updated Date',
            'updatedBy' => 'Updated By',
            'status' => 'Status',
        ];
    }
}

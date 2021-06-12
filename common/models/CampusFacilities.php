<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "campus_facilities".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @property string $updatedDate
 * @property string $createdDate
 */
class CampusFacilities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'campus_facilities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['status'], 'integer'],
            [['updatedDate', 'createdDate'], 'safe'],
            [['name'], 'string', 'max' => 500],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->createdDate = date('Y-m-d H:i:s');
            }
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
            'status' => 'Status',
            'updatedDate' => 'Updated Date',
            'createdDate' => 'Created Date',
        ];
    }
}

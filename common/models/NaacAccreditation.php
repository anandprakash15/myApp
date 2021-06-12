<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "naac_accreditation".
 *
 * @property int $id
 * @property int $institutional_cgpa
 * @property string $grade
 * @property string $performance_descriptor
 * @property int $status
 * @property string $createdDate
 * @property string $updatedDate
 * @property int $createdBy
 * @property int $updatedBy
 */
class NaacAccreditation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'naac_accreditation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['performance_descriptor', 'institutional_cgpa'], 'string'],
            [['status'], 'required'],
            [['createdDate', 'updatedDate', 'grade'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'institutional_cgpa' => 'Institutional CGPA',
            'grade' => 'Grade',
            'performance_descriptor' => 'Performance Descriptor',
            'status' => 'Status',
            'createdDate' => 'Created Date',
            'updatedDate' => 'Updated Date',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
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
}

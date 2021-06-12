<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ucc_details".
 *
 * @property int $id
 * @property int $uccID
 * @property string $fees
 * @property string $description
 * @property string $duration
 * @property string $approved_by
 * @property string $accredited_by
 * @property int $createdBy
 * @property int $updatedBy
 * @property string $createdDate
 * @property string $updatedDate
 *
 * @property User $createdBy0
 * @property User $updatedBy0
 */
class UccDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ucc_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uccID', 'fees', 'description', 'duration', 'approved_by', 'accredited_by', 'createdBy', 'updatedBy', 'createdDate'], 'required'],
            [['uccID', 'createdBy', 'updatedBy'], 'integer'],
            [['fees', 'description', 'approved_by', 'accredited_by'], 'string'],
            [['createdDate', 'updatedDate'], 'safe'],
            [['duration'], 'string', 'max' => 50],
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
            'uccID' => 'Ucc ID',
            'fees' => 'Fees',
            'description' => 'Description',
            'duration' => 'Duration',
            'approved_by' => 'Approved By',
            'accredited_by' => 'Accredited By',
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
}

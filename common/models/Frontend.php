<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "frontend".
 *
 * @property int $id
 * @property string $about
 * @property int $about_status
 * @property string $privacy
 * @property int $privacy_status
 * @property string $term_condition
 * @property int $term_condition_status
 * @property string $vision
 * @property int $vision_status
 * @property string $mission
 * @property int $mission_status
 * @property string $disclaimer
 * @property int $disclaimer_status
 * @property string $faq
 * @property int $faq_status
 * @property string $contact_us
 * @property int $contact_us_status
 * @property string $site_map
 * @property int $site_map_status
 * @property string $why_choose_us
 * @property int $wcu_status
 * @property string $management_team
 * @property int $mt_status
 * @property string $careers
 * @property int $careers_status
 * @property string $our_blog
 * @property int $ob_status
 * @property int $createdBy
 * @property int $updatedBy
 * @property string $created_date
 * @property string $updated_date
 *
 * @property User $createdBy0
 * @property User $updatedBy0
 */
class Frontend extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'frontend';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['about', 'privacy', 'term_condition', 'vision', 'mission', 'disclaimer', 'faq', 'contact_us', 'site_map', 'why_choose_us', 'management_team', 'careers', 'our_blog'], 'string'],
            [['about_status', 'privacy_status', 'term_condition_status', 'vision_status', 'mission_status', 'disclaimer_status', 'faq_status', 'contact_us_status', 'site_map_status', 'wcu_status', 'mt_status', 'careers_status', 'ob_status', 'createdBy', 'updatedBy'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['createdBy' => 'id']],
            [['updatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updatedBy' => 'id']],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->createdBy = \Yii::$app->user->identity->id;
                $this->created_date = date('Y-m-d H:i:s');
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
            'about' => 'About',
            'about_status' => 'About Status',
            'privacy' => 'Privacy',
            'privacy_status' => 'Privacy Status',
            'term_condition' => 'Term Condition',
            'term_condition_status' => 'Term Condition Status',
            'vision' => 'Vision',
            'vision_status' => 'Vision Status',
            'mission' => 'Mission',
            'mission_status' => 'Mission Status',
            'disclaimer' => 'Disclaimer',
            'disclaimer_status' => 'Disclaimer Status',
            'faq' => 'Faq',
            'faq_status' => 'Faq Status',
            'contact_us' => 'Contact Us',
            'contact_us_status' => 'Contact Us Status',
            'site_map' => 'Site Map',
            'site_map_status' => 'Site Map Status',
            'why_choose_us' => 'Why Choose Us',
            'wcu_status' => 'Why Choose Us Status',
            'management_team' => 'Management Team',
            'mt_status' => 'Management Team Status',
            'careers' => 'Careers',
            'careers_status' => 'Careers Status',
            'our_blog' => 'Our Blog',
            'ob_status' => 'Our Blog Status',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
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

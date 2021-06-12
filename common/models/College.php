<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "college".
 *
 * @property int $id
 * @property string $name
  * @property string $sortname
 * @property string $bannerURL
 * @property string $area
 * @property string $code
 * @property string $address
 * @property int $cityID
 * @property int $stateID
 * @property int $countryID
 * @property string $taluka
 * @property string $district
 * @property string $pincode
 * @property string $contact
 * @property string $fax
 * @property string $email
 * @property string $websiteurl
 * @property string $establish_year
 * @property string $approved_by
 * @property string $accredited_by
 * @property string $affiliate_to
 * @property string $rating
 * @property string $about
 * @property string $vission
 * @property string $mission
 * @property string $logourl
 * @property int $ownership
 * @property string $brochureurl
 * @property string $createdDate
 * @property string $updatedDate
 * @property int $status
 * @property int $createdBy
 * @property int $updatedBy
 *
 * @property User $createdBy0
 * @property User $updatedBy0
 * @property CollegeGallery[] $collegeGalleries
 * @property CollegeType[] $collegeTypes
 */
class College extends \yii\db\ActiveRecord
{
    public $bannerImg;
    public $brochureFile;
    public $logoImg;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'college';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['bannerImg','logoImg'], 'file', 'extensions'=>'jpg, jpeg, png'],
            [['brochureFile'], 'file', 'extensions'=>'pdf, doc, docx'],
            [['cityID', 'stateID', 'countryID','ownership', 'status', 'createdBy', 'updatedBy'], 'integer'],
            [['about', 'vission', 'mission'], 'string'],
            [['createdDate', 'updatedDate','sortname','bannerURL','area','approved_by', 'accredited_by', 'affiliate_to'], 'safe'],
            [['name', 'address','brochureurl'], 'string', 'max' => 500],
            [['code', 'taluka', 'district', 'contact', 'fax', 'email', 'logourl'], 'string', 'max' => 100],
            [['pincode'], 'string', 'max' => 20],
            ['code', 'codeunique'],
            [['websiteurl'], 'string', 'max' => 265],
            [['establish_year'], 'string', 'max' => 50],
            [['rating'], 'string', 'max' => 10],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['createdBy' => 'id']],
            [['updatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updatedBy' => 'id']],
        ];
    }

    public function codeunique($attribute,$params)
    {
        $check = '';
        if(!$this->isNewRecord){
            $id = $this->id;
            $check = College::find()->where(['code'=>$this->code])->andWhere(['<>','id',$id])->one();
        }else{
            $check = College::find()->where(['code'=>$this->code])->one();
        }
        if(!empty($check)){
            $this->addError($attribute, $this->code.' This code has already been taken');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'sortname' => 'Short Name',
            'bannerURL' => 'College Image',
            'area' => 'Area',
            'code' => 'Code',
            'address' => 'Address',
            'cityID' => 'City',
            'stateID' => 'State',
            'countryID' => 'Country',
            'taluka' => 'Taluka',
            'district' => 'District',
            'pincode' => 'Pincode',
            'contact' => 'Contact',
            'fax' => 'Fax',
            'email' => 'Email',
            'websiteurl' => 'Website Url',
            'establish_year' => 'Establish Year',
            'approved_by' => 'Approved By',
            'accredited_by' => 'Accredited By',
            'affiliate_to' => 'Affiliate To',
            'rating' => 'Rating',
            'about' => 'About',
            'vission' => 'Vission',
            'mission' => 'Mission',
            'logourl' => 'College Logo',
            'ownership' => 'Ownership',
            'brochureurl' => 'Brochure File',
            'createdDate' => 'Created Date',
            'updatedDate' => 'Updated Date',
            'status' => 'Status',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
            'ctype' => 'College Type',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $maxcode = College::find()->max('code');
                if(empty($maxcode)){
                    $maxcode = 0;
                }
                $this->code = $maxcode+1;
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
    public function getCollegeGalleries()
    {
        return $this->hasMany(CollegeGallery::className(), ['collegeID' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeTypes()
    {
        return $this->hasMany(CollegeType::className(), ['collegeID' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['id' => 'countryID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'cityID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(States::className(), ['id' => 'stateID']);
    }
}

<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "university".
 *
 * @property int $id
 * @property string $name
 * @property string $short_name
 * @property string $also_known_as
 * @property string $bannerURL
 * @property string $area
 * @property string $code
 * @property string $utype
 * @property string $approving_government_authority
 * @property string $address
 * @property int $cityID
 * @property int $stateID
 * @property int $countryID
 * @property string $taluka
 * @property string $district
 * @property string $pincode
 * @property int $isd_codesID
 * @property string $std_code
 * @property string $contact
 * @property string $fax
 * @property string $email
 * @property string $websiteurl
 * @property string $establish_year
 * @property string $approved_by
 * @property string $accredited_by
 * @property string $grade
 * @property string $naac_cgpa
 * @property string $naac_validity_date
 * @property string $about
 * @property int $campus_size
 * @property string $vision
 * @property string $mission
 * @property string $motto
 * @property string $colours
 * @property string $founder
 * @property string $chancellor
 * @property string $vice_chancellor
 * @property string $affiliate_to
 * @property string $logourl
 * @property string $longitude
 * @property string $latitude
 * @property string $createdDate
 * @property string $updatedDate
 * @property int $status
 * @property int $createdBy
 * @property int $updatedBy
 *
 * @property User $createdBy0
 * @property User $updatedBy0
 * @property UniversityCourse[] $universityCourses
 * @property UniversityType[] $universityTypes
 */
class University extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $bannerImg;
    public $logoImg;
    public static function tableName()
    {
        return 'university';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['bannerImg','logoImg'], 'file', 'extensions'=>'jpg, jpeg, png'],
            
            [['cityID', 'stateID', 'countryID', 'status', 'createdBy', 'updatedBy','isd_codesID'], 'integer'],
            [['about','utype', 'vision', 'mission', 'motto', 'colours','also_known_as'], 'string'],
            [['createdDate', 'updatedDate','short_name','bannerURL','area','approved_by', 'accredited_by', 'std_code', 'affiliate_to', 'approving_government_authority', 'naac_cgpa', 'naac_validity_date','campus_size'], 'safe'],

            [['name'], 'string', 'max' => 300],
            [['pincode', 'establish_year'], 'string', 'max' => 20],
            [['address', 'founder', 'chancellor', 'vice_chancellor'], 'string', 'max' => 500],
            [['taluka', 'district', 'contact', 'fax', 'email', 'logourl'], 'string', 'max' => 50],
            [['websiteurl', 'longitude', 'latitude'], 'string', 'max' => 100],
            [['grade'], 'string', 'max' => 10],
            ['code', 'codeunique'],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['createdBy' => 'id']],
            [['updatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updatedBy' => 'id']],
        ];
    }

    public function codeunique($attribute,$params)
    {
        $check = '';
        if(!$this->isNewRecord){
            $id = $this->id;
            $check = University::find()->where(['code'=>$this->code])->andWhere(['<>','id',$id])->one();
        }else{
            $check = University::find()->where(['code'=>$this->code])->one();
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
            'name' => 'University Name',
            'short_name' => 'Short Name',
            'also_known_as' => 'Also Known As',
            'bannerURL' => 'Banner Url',
            'area' => 'Area',
            'code' => 'Code',
            'address' => 'Address',
            'cityID' => 'City',
            'stateID' => 'State',
            'countryID' => 'Country',
            'taluka' => 'Taluka',
            'district' => 'District',
            'pincode' => 'Pincode',
            'isd_codesID' => 'ISD Code',
            'std_code' => 'STD Code',
            'contact' => 'Contact',
            'fax' => 'Fax',
            'email' => 'Email',
            'websiteurl' => 'Website URL',
            'establish_year' => 'Establish Year',
            'approved_by' => 'Approved By',
            'accredited_by' => 'Accredited By',
            'grade' => 'NAAC Grade',
            'naac_cgpa' => 'NAAC CGPA',
            'naac_validity_date' => 'NAAC Validity Date',
            'about' => 'About',
            'campus_size' => 'Campus Size',
            'vision' => 'Vision',
            'mission' => 'Mission',
            'motto' => 'Motto',
            'colours' => 'Colours',
            'founder' => 'Founder',
            'chancellor' => 'Chancellor',
            'vice_chancellor' => 'Vice Chancellor',
            'affiliated_to' => 'Affiliated To',
            'logourl' => 'Logourl',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'createdDate' => 'Created Date',
            'updatedDate' => 'Updated Date',
            'status' => 'Status',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
            'bannerImg' => 'Banner Image',
            'brochureImg' => 'Brochure Upload',
            'logoImg' => 'University Logo',
            'utype' => 'University Type',
            'approving_government_authority' => 'Approving Government Authority',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $maxcode = University::find()->max('code');
                if(empty($maxcode)){
                    $maxcode = 0;
                }
                $this->code = $maxcode + 1; 
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
    public function getUniversityCourses()
    {
        return $this->hasMany(UniversityCourse::className(), ['universityID' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniversityTypes()
    {
        return $this->hasMany(UniversityType::className(), ['universityID' => 'id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIsdCodes()
    {
        return $this->hasOne(IsdCodes::className(), ['id' => 'isd_codesID']);
    }
}

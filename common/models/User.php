<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $fullname
 * @property string $gender
 * @property string $mobile
 * @property string $email
 * @property string $higestEduction
 * @property int $collegeID
 * @property int $programID
 * @property string $password
 * @property string $auth_key
 * @property string $password_reset_token
 * @property string $password_reset_date
 * @property string $state
 * @property string $city
 * @property string $pincode
 * @property string $country
 * @property int $roleID
 * @property int $createdBy
 * @property string $createdDate
 * @property string $updatedDate
 * @property int $status 0- enabled, 1- disabled, 2-deleted, 3 - reset
 *
 * @property Advertise[] $advertises
 * @property Advertise[] $advertises0
 * @property College[] $colleges
 * @property College[] $colleges0
 * @property CollegeGallery[] $collegeGalleries
 * @property CollegeGallery[] $collegeGalleries0
 * @property CollegeType[] $collegeTypes
 * @property CollegeType[] $collegeTypes0
 * @property CollegeUniversityAdvpurpose[] $collegeUniversityAdvpurposes
 * @property CollegeUniversityAdvpurpose[] $collegeUniversityAdvpurposes0
 * @property Courses[] $courses
 * @property Courses[] $courses0
 * @property Exam[] $exams
 * @property Exam[] $exams0
 * @property ExamCategory[] $examCategories
 * @property ExamCategory[] $examCategories0
 * @property NewsArtical[] $newsArticals
 * @property NewsArtical[] $newsArticals0
 * @property NewsArticalGallery[] $newsArticalGalleries
 * @property NewsArticalGallery[] $newsArticalGalleries0
 * @property Program[] $programs
 * @property Program[] $programs0
 * @property Review[] $reviews
 * @property Review[] $reviews0
 * @property Specialization[] $specializations
 * @property Specialization[] $specializations0
 * @property University[] $universities
 * @property University[] $universities0
 * @property UniversityCourse[] $universityCourses
 * @property UniversityCourse[] $universityCourses0
 * @property UniversityGallery[] $universityGalleries
 * @property UniversityGallery[] $universityGalleries0
 * @property UniversityType[] $universityTypes
 * @property UniversityType[] $universityTypes0
 * @property Role $role
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    public $confirmpassword;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    /*public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }*/

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fullname', 'gender', 'mobile', 'email'], 'required'],
            [['collegeID', 'programID', 'roleID', 'createdBy', 'status'], 'integer'],
            [['password_reset_date', 'createdDate', 'updatedDate'], 'safe'],
            [['fullname', 'city', 'country'], 'string', 'max' => 50],
            [['gender'], 'string', 'max' => 5],
            [['mobile'], 'string', 'max' => 15],
            [['email', 'higestEduction', 'auth_key', 'password_reset_token'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 200],
            ['confirmpassword', 'compare', 'compareAttribute' => 'password'],
            ['email','email'],
            ['email', 'emailunique'],
            [['state'], 'string', 'max' => 300],
            [['pincode'], 'string', 'max' => 20],
            [['roleID'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['roleID' => 'id']],
        ];
    }

    public function emailunique($attribute,$params)
    {
        $check = '';
        if(!$this->isNewRecord){
            $userid = $this->id;
            $check = User::find()->where(['email'=>$this->email])->andWhere(['<>','id',$userid])->andWhere(['<>','status',2])->one();
        }else{
            if(!isset($_GET['token'])){
                $check = User::find()->where(['email'=>$this->email])->andWhere(['<>','status',2])->one();
            }
        }
        if(!empty($check)){
            $this->addError($attribute, $this->email.' This email address has already been taken');
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->createdBy = \Yii::$app->user->identity->id;
               // $this->updatedBy = \Yii::$app->user->identity->id;
                $this->createdDate = date('Y-m-d H:i:s');
                $this->password = Yii::$app->security->generatePasswordHash($this->password);
            }
            return true;
        }
        //$this->updatedBy = \Yii::$app->user->identity->id;
        return false;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fullname' => 'Fullname',
            'gender' => 'Gender',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'higestEduction' => 'Higest Eduction',
            'collegeID' => 'College ID',
            'programID' => 'Program ID',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
            'password_reset_date' => 'Password Reset Date',
            'state' => 'State',
            'city' => 'City',
            'pincode' => 'Pincode',
            'country' => 'Country',
            'roleID' => 'Role ID',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'updatedDate' => 'Updated Date',
            'status' => 'Status',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param string $username
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


}

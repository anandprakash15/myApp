<?php

namespace common\models;

use Yii;

/** 
 * This is the model class for table "course_details". 
 * 
 * @property int $id
 * @property int $affiliation_type 1-Autonomous 2-Affiliated
 * @property int $course_mode 1-Regular 2-Distance Learning 3-Correspondence 4-Online Mode 5-Hybrid Mode 6-MOOCs (massive open online courses)
 * @property string $eligibility_criteria
 * @property string $course_curriculum
 * @property string $entrance_exams_accepted
 * @property string $admission_process
 * @property string $important_dates
 * @property string $course_credits
 * @property string $fee_breakup
 * @property string $seat_breakup
 * @property int $approved_intake
 * @property int $stream_wise_intake
 * @property int $placement_data 1-Highest Package National 2-Highest Package International 3-Average Package 4-Lowest Package
 * @property string $start_year
 * @property int $accreditation_status
 * @property string $nri_quota
 * @property string $jk_quota
 * @property string $foreign_collaboration
 * @property string $foreign_university
 * @property int $shift 1-First Shift 2-Second Shift 3-Third Shift
 * @property string $duration
 * @property string $fees
 * @property int $approved_by
 * @property string $register_url
 * @property int $uccID
 * @property string $description
 * @property string $updatedDate
 * @property int $updatedBy
 * @property int $createdBy
 * @property string $createdDate
 * @property int $status
 */
class CourseDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const SCENARIO_UNIVERSITY_COURSE = 'university-course';
    const SCENARIO_COLLEGE_COURSE = 'college-course';

    public static function tableName()
    {
        return 'course_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['duration','affiliation_type', 'fees', 'uccID', 'description', 'updatedBy', 'createdBy', 'status'], 'required'],
            [['affiliation_type', 'course_mode', 'approved_intake', 'stream_wise_intake', 'placement_data', 'accreditation_status', 'shift', 'uccID', 'status'], 'integer'],
            [['eligibility_criteria', 'course_curriculum', 'admission_process', 'important_dates', 'course_credits', 'fee_breakup', 'seat_breakup', 'nri_quota', 'jk_quota', 'foreign_collaboration', 'duration', 'description'], 'string'],
            [['start_year', 'updatedDate', 'createdDate','approved_by'], 'safe'],
            [['course_mode'], 'required','on'=>self::SCENARIO_UNIVERSITY_COURSE],
            [['foreign_university','register_url'], 'string', 'max' => 500],
            [['fees'], 'string', 'max' => 100],
        ]; 
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_UNIVERSITY_COURSE] = ['eligibility_criteria','course_curriculum','admission_process','important_dates','course_credits', 'register_url', 'status'];
        $scenarios[self::SCENARIO_COLLEGE_COURSE] = ['affiliation_type','course_mode','eligibility_criteria','course_curriculum','entrance_exams_accepted', 'fees','fee_breakup', 'seat_breakup', 'nri_quota', 'jk_quota','admission_process','important_dates','course_credits','approved_intake','start_year','accreditation_status','foreign_collaboration','foreign_university','register_url','shift','status','approved_by'];
        return $scenarios;
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
            'affiliation_type' => 'Affiliation Type',
            'course_mode' => 'Course Mode',
            'eligibility_criteria' => 'Eligibility Criteria',
            'course_curriculum' => 'Course Curriculum',
            'entrance_exams_accepted' => 'Entrance Exams',
            'admission_process' => 'Admission Process',
            'important_dates' => 'Important Dates',
            'course_credits' => 'Course Credits',
            'fee_breakup' => 'Fee Breakup',
            'seat_breakup' => 'Seat Breakup',
            'approved_intake' => 'Approved Intake',
            'stream_wise_intake' => 'Stream Wise Intake',
            'placement_data' => 'Placement Data',
            'start_year' => 'Start Year',
            'accreditation_status' => 'Accreditation Status',
            'nri_quota' => 'Nri Quota',
            'jk_quota' => 'Jk Quota',
            'foreign_collaboration' => 'Foreign Collaboration',
            'foreign_university' => 'Foreign University',
            'shift' => 'Shift',
            'duration' => 'Duration',
            'fees' => 'Course Fees',
            'approved_by' => 'Approved By',
            'register_url' => 'Registration URL',
            'uccID' => 'Ucc ID',
            'description' => 'Course Description',
            'updatedDate' => 'Updated Date',
            'updatedBy' => 'Updated By',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'status' => 'Status',
        ]; 
    } 
}

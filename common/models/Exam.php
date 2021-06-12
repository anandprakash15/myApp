<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "exam".
 *
 * @property int $id
 * @property int $programID
 * @property int $courseID
 * @property string $exam_name
 * @property string $exam_mode
 * @property string $exam_level
 * @property string $short_code
 * @property int $exam_course_level
 * @property string $highlights
 * @property string $eligibility_criteria
 * @property string $registration_fees
 * @property string $late_fees
 * @property string $registration_start_date
 * @property string $registration_start_time
 * @property string $registration_closing_time
 * @property string $registration_end_date
 * @property string $registration_extended_date_from
 * @property string $registration_extended_date_to
 * @property string $admit_card_download_start_date
 * @property string $admit_card_download_end_date
 * @property string $online_exam_date
 * @property string $paper_based_exam_date
 * @property string $result_date
 * @property string $analysis
 * @property string $results
 * @property string $cut_off
 * @property string $syllabus
 * @property string $exam_pattern
 * @property string $exam_duration
 * @property string $no_of_questions
 * @property string $total_marks
 * @property string $language_of_paper
 * @property string $marks_per_question
 * @property string $negative_marks_per_question
 * @property string $do_dont_during_the_exam
 * @property string $exam_registration_website
 * @property string $conducting_authority
 * @property string $exam_centres
 * @property string $exam_helpline_nos
 * @property string $helpline_emails
 * @property string $registration_process
 * @property string $registration_documents
 * @property string $number_of_exam_cities
 * @property string $exam_books_guide
 * @property string $question_papers
 * @property string $exam_FAQ
 * @property string $preparation_tips
 * @property string $useful_tips
 * @property string $coaching_classes
 * @property string $createdDate
 * @property string $updatedDate
 * @property int $createdBy
 * @property int $updatedBy
 * @property int $status
 */
class Exam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exam';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['programID','courseID'], 'required'],
            [['programID', 'courseID', 'exam_course_level', 'createdBy', 'updatedBy','status'], 'integer'],
            [['exam_name', 'exam_mode', 'exam_level','short_code', 'highlights', 'eligibility_criteria', 'registration_fees', 'late_fees', 'registration_start_date', 'registration_start_time', 'registration_closing_time', 'registration_end_date', 'registration_extended_date_from', 'registration_extended_date_to', 'admit_card_download_start_date', 'admit_card_download_end_date', 'online_exam_date', 'paper_based_exam_date', 'result_date', 'analysis', 'results', 'cut_off', 'syllabus', 'exam_pattern', 'exam_duration', 'no_of_questions', 'total_marks', 'language_of_paper', 'marks_per_question', 'negative_marks_per_question', 'do_dont_during_the_exam', 'exam_registration_website', 'conducting_authority', 'exam_centres', 'exam_helpline_nos', 'helpline_emails', 'registration_process', 'registration_documents', 'number_of_exam_cities', 'exam_books_guide', 'question_papers', 'exam_FAQ', 'coaching_classes', 'preparation_tips','useful_tips'], 'string'],
            [['createdDate', 'updatedDate'], 'safe'],

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
            'programID' => 'Program',
            'courseID' => 'Course',
            'exam_name' => 'Exam Name',
            'exam_mode' => 'Exam Mode',
            'exam_level' => 'Exam Level',
            'short_code' => 'Short Code',
            'exam_course_level' => 'Course Level',
            'highlights' => 'Exam Highlights',
            'eligibility_criteria' => 'Eligibility Criteria',
            'registration_fees' => 'Registration Fees',
            'late_fees' => 'Late Fees',
            'registration_start_date' => 'Registration Start Date',
            'registration_start_time' => 'Registration Start Time',
            'registration_closing_time' => 'Registration Closing Time',
            'registration_end_date' => 'Registration End Date',
            'registration_extended_date_from' => 'Registration Extended Date From',
            'registration_extended_date_to' => 'Registration Extended Date To',
            'admit_card_download_start_date' => 'Admit Card Download Start Date',
            'admit_card_download_end_date' => 'Admit Card Download End Date',
            'online_exam_date' => 'Online Exam Date',
            'paper_based_exam_date' => 'Paper Based Exam Date',
            'result_date' => 'Result Date',
            'results' => 'Results',
            'analysis' => 'Exam Analysis',
            'cut_off' => 'Percentage Cut Off',
            'syllabus' => 'Syllabus',
            'exam_pattern' => 'Exam Pattern',
            'exam_duration' => 'Exam Duration',
            'no_of_questions' => 'No of Questions',
            'total_marks' => 'Total Marks',
            'language_of_paper' => 'Language Paper',
            'marks_per_question' => 'Marks Per Question',
            'negative_marks_per_question' => 'Negative Marks Per Question',
            'do_dont_during_the_exam' => "Do's Dont During The Exam",
            'exam_registration_website' => 'Exam Registration Website',
            'conducting_authority' => 'Conducting Authority',
            'exam_centres' => 'Exam Centres',
            'exam_helpline_nos' => 'Exam Helpline Nos.',
            'helpline_emails' => 'Helpline Emails',
            'registration_process' => 'Registration Process',
            'registration_documents' => 'Registration Documents',
            'number_of_exam_cities' => 'Number of Exam Cities',
            'exam_books_guide' => 'Exam Books Guide',
            'question_papers' => 'Question Papers',
            'exam_FAQ' => 'Exam FAQ',
            'preparation_tips' => 'Preparation Tips',
            'useful_tips'=> 'Useful Tips', 
            'coaching_classes' => 'Coaching Classes',
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

    public function getProgram()
    {
        return $this->hasOne(Program::className(), ['id' => 'programID']);
    }

    public function getCourse()
    {
        return $this->hasOne(Courses::className(), ['id' => 'courseID']);
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

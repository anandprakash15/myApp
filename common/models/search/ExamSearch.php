<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Exam;

/**
 * ExamSearch represents the model behind the search form of `common\models\Exam`.
 */
class ExamSearch extends Exam
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'programID', 'courseID', 'exam_course_level', 'status','createdBy', 'updatedBy'], 'integer'],
            [['exam_name', 'exam_mode', 'short_code', 'highlights', 'registration_end_date', 'registration_extended_date_from', 'registration_extended_date_to', 'admit_card_download_start_date', 'admit_card_download_end_date', 'online_exam_date', 'paper_based_exam_date', 'result_date', 'analysis', 'cut_off', 'syllabus', 'exam_pattern', 'exam_duration', 'no_of_questions', 'total_marks', 'language_of_paper', 'marks_per_question', 'negative_marks_per_question', 'do_dont_during_the_exam', 'exam_registration_website', 'conducting_authority', 'exam_centres', 'exam_helpline_nos', 'number_of_exam_cities', 'exam_books_guide', 'question_papers', 'exam_FAQ', 'createdDate', 'updatedDate'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Exam::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'programID' => $this->programID,
            'courseID' => $this->courseID,
            'exam_course_level' => $this->exam_course_level,
            'createdDate' => $this->createdDate,
            'updatedDate' => $this->updatedDate,
            'createdBy' => $this->createdBy,
            'updatedBy' => $this->updatedBy,
        ]);

        $query->andFilterWhere(['like', 'exam_name', $this->exam_name])
            ->andFilterWhere(['like', 'exam_mode', $this->exam_mode])
            ->andFilterWhere(['like', 'short_code', $this->short_code])
            ->andFilterWhere(['like', 'highlights', $this->highlights])
            ->andFilterWhere(['like', 'registration_end_date', $this->registration_end_date])
            ->andFilterWhere(['like', 'registration_extended_date_from', $this->registration_extended_date_from])
            ->andFilterWhere(['like', 'registration_extended_date_to', $this->registration_extended_date_to])
            ->andFilterWhere(['like', 'admit_card_download_start_date', $this->admit_card_download_start_date])
            ->andFilterWhere(['like', 'admit_card_download_end_date', $this->admit_card_download_end_date])
            ->andFilterWhere(['like', 'online_exam_date', $this->online_exam_date])
            ->andFilterWhere(['like', 'paper_based_exam_date', $this->paper_based_exam_date])
            ->andFilterWhere(['like', 'result_date', $this->result_date])
            ->andFilterWhere(['like', 'analysis', $this->analysis])
            ->andFilterWhere(['like', 'cut_off', $this->cut_off])
            ->andFilterWhere(['like', 'syllabus', $this->syllabus])
            ->andFilterWhere(['like', 'exam_pattern', $this->exam_pattern])
            ->andFilterWhere(['like', 'exam_duration', $this->exam_duration])
            ->andFilterWhere(['like', 'no_of_questions', $this->no_of_questions])
            ->andFilterWhere(['like', 'total_marks', $this->total_marks])
            ->andFilterWhere(['like', 'language_of_paper', $this->language_of_paper])
            ->andFilterWhere(['like', 'marks_per_question', $this->marks_per_question])
            ->andFilterWhere(['like', 'negative_marks_per_question', $this->negative_marks_per_question])
            ->andFilterWhere(['like', 'do_dont_during_the_exam', $this->do_dont_during_the_exam])
            ->andFilterWhere(['like', 'exam_registration_website', $this->exam_registration_website])
            ->andFilterWhere(['like', 'conducting_authority', $this->conducting_authority])
            ->andFilterWhere(['like', 'exam_centres', $this->exam_centres])
            ->andFilterWhere(['like', 'exam_helpline_nos', $this->exam_helpline_nos])
            ->andFilterWhere(['like', 'number_of_exam_cities', $this->number_of_exam_cities])
            ->andFilterWhere(['like', 'exam_books_guide', $this->exam_books_guide])
            ->andFilterWhere(['like', 'question_papers', $this->question_papers])
            ->andFilterWhere(['like', 'exam_FAQ', $this->exam_FAQ]);

        return $dataProvider;
    }
}

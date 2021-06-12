<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UniversityCollegeCourse;

/**
 * UniversityCollegeCourseSearch represents the model behind the search form of `common\models\UniversityCollegeCourse`.
 */
class UniversityCollegeCourseSearch extends UniversityCollegeCourse
{
    /**
     * {@inheritdoc}
     */
    public $course_name;
    public $university_name;
    public $college_name;
    public $program_name;
    public function rules()
    {
        return [
            [['id', 'universityID', 'collegeID', 'courseID', 'status', 'createdBy', 'updatedBy'], 'integer'],
            [['createdDate', 'updatedDate','course_name','university_name','college_name','program_name'], 'safe'],
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
    public function search($params,$id,$type='university')
    {
        $query = UniversityCollegeCourse::find();
        if($type == 'university'){
            $query->andWhere(['university_college_course.universityID'=>$id,'university_college_course.collegeID'=>NULL]);
        }else{
            $query->andWhere(['university_college_course.collegeID'=>$id]);
        }

        $query->joinWith(['course'=>function($q){
            $q->joinWith(['program']);
        }]);
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
            'universityID' => $this->universityID,
            'collegeID' => $this->collegeID,
            'courseID' => $this->courseID,
            'createdDate' => $this->createdDate,
            'updatedDate' => $this->updatedDate,
            'status' => $this->status,
            'createdBy' => $this->createdBy,
            'updatedBy' => $this->updatedBy,
        ]);

        $query->andFilterWhere(['like', 'courses.name', $this->course_name])
            ->andFilterWhere(['like', 'program.name', $this->program_name]);

        return $dataProvider;
    }
}

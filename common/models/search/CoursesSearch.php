<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Courses;

/**
 * CoursesSearch represents the model behind the search form of `common\models\Courses`.
 */
class CoursesSearch extends Courses
{
    /**
     * @inheritdoc
     */
    public $program;
    public function rules()
    {
        return [
            [['id', 'programID', 'sortno', 'certification_type', 'status', 'createdBy', 'updatedBy', 'full_part_time', 'courseType'], 'integer'],
            [['name', 'code', 'createdDate', 'updatedDate','program','short_name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Courses::find()->joinWith(['program']);

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
            'sortno' => $this->sortno,
            'certification_type' => $this->certification_type,
            'createdDate' => $this->createdDate,
            'updatedDate' => $this->updatedDate,
            'courses.status' => $this->status,
            'createdBy' => $this->createdBy,
            'updatedBy' => $this->updatedBy,
            'full_part_time' => $this->full_part_time,
            'courseType' => $this->courseType,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'courses.short_name', $this->short_name])
            ->andFilterWhere(['like', 'program.name', $this->program]);
        return $dataProvider;
    }
}

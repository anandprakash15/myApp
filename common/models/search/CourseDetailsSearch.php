<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CourseDetails;

/**
 * CourseDetailsSearch represents the model behind the search form of `common\models\CourseDetails`.
 */
class CourseDetailsSearch extends CourseDetails
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'uccID', 'updatedBy', 'createdBy', 'status'], 'integer'],
            [['duration', 'fees', 'description', 'updatedDate', 'createdDate'], 'safe'],
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
        $query = CourseDetails::find();

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
            'uccID' => $this->uccID,
            'updatedDate' => $this->updatedDate,
            'updatedBy' => $this->updatedBy,
            'createdBy' => $this->createdBy,
            'createdDate' => $this->createdDate,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'duration', $this->duration])
            ->andFilterWhere(['like', 'fees', $this->fees])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}

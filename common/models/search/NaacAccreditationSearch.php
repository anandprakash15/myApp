<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\NaacAccreditation;

/**
 * NaacAccreditationSearch represents the model behind the search form of `common\models\NaacAccreditation`.
 */
class NaacAccreditationSearch extends NaacAccreditation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'createdBy', 'updatedBy'], 'integer'],
            [['grade', 'institutional_cgpa', 'performance_descriptor', 'createdDate', 'updatedDate'], 'safe'],
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
        $query = NaacAccreditation::find();

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
            'status' => $this->status,
            'createdDate' => $this->createdDate,
            'updatedDate' => $this->updatedDate,
            'createdBy' => $this->createdBy,
            'updatedBy' => $this->updatedBy,
        ]);

        $query->andFilterWhere(['like', 'grade', $this->grade])
            ->andFilterWhere(['like', 'performance_descriptor', $this->performance_descriptor])
            ->andFilterWhere(['like', 'institutional_cgpa', $this->institutional_cgpa]);

        return $dataProvider;
    }
}

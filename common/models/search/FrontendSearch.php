<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Frontend;

/**
 * FrontendSearch represents the model behind the search form of `common\models\Frontend`.
 */
class FrontendSearch extends Frontend
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'about_status', 'privacy_status', 'term_condition_status', 'createdBy', 'updatedBy'], 'integer'],
            [['about', 'privacy', 'term_condition', 'created_date', 'updated_date'], 'safe'],
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
        $query = Frontend::find();

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
            'about_status' => $this->about_status,
            'privacy_status' => $this->privacy_status,
            'term_condition_status' => $this->term_condition_status,
            'createdBy' => $this->createdBy,
            'updatedBy' => $this->updatedBy,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'about', $this->about])
            ->andFilterWhere(['like', 'privacy', $this->privacy])
            ->andFilterWhere(['like', 'term_condition', $this->term_condition]);

        return $dataProvider;
    }
}

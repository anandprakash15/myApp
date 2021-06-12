<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\NewsArtical;

/**
 * NewsArticalSearch represents the model behind the search form of `common\models\NewsArtical`.
 */
class NewsArticalSearch extends NewsArtical
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'natype', 'type', 'coll_univ_examID', 'programID', 'courseID', 'national_international', 'status', 'createdBy', 'updatedBy'], 'integer'],
            [['title', 'description', 'startDate', 'endDate', 'createdDate', 'updatedDate'], 'safe'],
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
        $query = NewsArtical::find();

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
            'natype' => $this->natype,
            'type' => $this->type,
            'coll_univ_examID' => $this->coll_univ_examID,
            'programID' => $this->programID,
            'courseID' => $this->courseID,
            'national_international' => $this->national_international,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'createdDate' => $this->createdDate,
            'updatedDate' => $this->updatedDate,
            'status' => $this->status,
            'createdBy' => $this->createdBy,
            'updatedBy' => $this->updatedBy,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}

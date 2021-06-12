<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Advertise;

/**
 * AdvertiseSearch represents the model behind the search form of `common\models\Advertise`.
 */
class AdvertiseSearch extends Advertise
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'coll_univID', 'college_university_advpurposeID', 'programID', 'courseID', 'cityID', 'stateID', 'countryID', 'status', 'createdBy', 'updatedBy'], 'integer'],
            [['fromDate', 'toDate', 'description', 'createdDate', 'updatedDate'], 'safe'],
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
        $query = Advertise::find()->joinWith(['university','college']);

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
            'type' => $this->type,
            'coll_univID' => $this->coll_univID,
            'college_university_advpurposeID' => $this->college_university_advpurposeID,
            'programID' => $this->programID,
            'courseID' => $this->courseID,
            'fromDate' => $this->fromDate,
            'toDate' => $this->toDate,
            'cityID' => $this->cityID,
            'stateID' => $this->stateID,
            'countryID' => $this->countryID,
            'createdDate' => $this->createdDate,
            'updatedDate' => $this->updatedDate,
            'status' => $this->status,
            'createdBy' => $this->createdBy,
            'updatedBy' => $this->updatedBy,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}

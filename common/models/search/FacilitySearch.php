<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Facility;

/**
 * FacilitySearch represents the model behind the search form of `common\models\Facility`.
 */
class FacilitySearch extends Facility
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'coll_univID', 'ftype', 'status', 'createdBy', 'updatedBy'], 'integer'],
            [['description', 'createdDate', 'updatedDate'], 'safe'],
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
        $query = Facility::find();
        if($type == 'university'){
            $query->andWhere(['facility.coll_univID'=>$id,'type'=>1]);
        }else{
            $query->andWhere(['facility.coll_univID'=>$id,'type'=>2]);
        }

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
            'ftype' => $this->ftype,
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

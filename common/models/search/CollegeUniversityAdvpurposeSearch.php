<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CollegeUniversityAdvpurpose;

/**
 * CollegeUniversityAdvpurposeSearch represents the model behind the search form of `common\models\CollegeUniversityAdvpurpose`.
 */
class CollegeUniversityAdvpurposeSearch extends CollegeUniversityAdvpurpose
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'coll_univID', 'gtype', 'status', 'createdBy', 'updatedBy'], 'integer'],
            [['url', 'createdDate', 'updatedDate'], 'safe'],
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
        $query = CollegeUniversityAdvpurpose::find();
        if($type == 'university'){
            $query->andWhere(['college_university_advpurpose.coll_univID'=>$id,'type'=>1]);
        }else{
            $query->andWhere(['college_university_advpurpose.coll_univID'=>$id,'type'=>2]);
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
            'gtype' => $this->gtype,
            'createdDate' => $this->createdDate,
            'updatedDate' => $this->updatedDate,
            'status' => $this->status,
            'createdBy' => $this->createdBy,
            'updatedBy' => $this->updatedBy,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}

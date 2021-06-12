<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Review;

/**
 * ReviewSearch represents the model behind the search form of `common\models\Review`.
 */
class ReviewSearch extends Review
{
    /**
     * {@inheritdoc}
     */
    public $fullname;
    public function rules()
    {
        return [
            [['id', 'type', 'coll_univID', 'courseID', 'status', 'createdBy', 'updatedBy'], 'integer'],
            [['placement_star', 'infrastructure_star', 'fcc_star', 'ccl_star', 'wtd_star', 'other_star'], 'number'],
            [['placement_review', 'infrastructure_review', 'fcc_review', 'cct_review', 'wtd_review', 'other_review', 'createdDate', 'updatedDate','fullname'], 'safe'],
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
        $query = Review::find()->joinWith(['createdBy0']);
        if($type == 'university'){
            $query->andWhere(['review.coll_univID'=>$id,'type'=>1]);
        }else{
            $query->andWhere(['review.coll_univID'=>$id,'type'=>2]);
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
            'courseID' => $this->courseID,
            'placement_star' => $this->placement_star,
            'infrastructure_star' => $this->infrastructure_star,
            'fcc_star' => $this->fcc_star,
            'ccl_star' => $this->ccl_star,
            'wtd_star' => $this->wtd_star,
            'other_star' => $this->other_star,
            
            'updatedDate' => $this->updatedDate,
            'status' => $this->status,
            'createdBy' => $this->createdBy,
            'updatedBy' => $this->updatedBy,
        ]);

        $query->andFilterWhere(['like', 'placement_review', $this->placement_review])
            ->andFilterWhere(['like', 'infrastructure_review', $this->infrastructure_review])
            ->andFilterWhere(['like', 'createdDate', $this->createdDate])
            ->andFilterWhere(['like', 'fcc_review', $this->fcc_review])
            ->andFilterWhere(['like', 'user.fullname', $this->fullname])
            ->andFilterWhere(['like', 'cct_review', $this->cct_review])
            ->andFilterWhere(['like', 'wtd_review', $this->wtd_review])
            ->andFilterWhere(['like', 'other_review', $this->other_review]);

        return $dataProvider;
    }
}

<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UniversityCourse;

/**
 * UniversityCourseSearch represents the model behind the search form of `common\models\UniversityCourse`.
 */
class UniversityCourseSearch extends UniversityCourse
{
    /**
     * {@inheritdoc}
     */
    public $cname;
    public $specialization;
    public $program;
    public function rules()
    {
        return [
            [['id', 'universityID', 'courseID', 'status', 'createdBy', 'updatedBy'], 'integer'],
            [['createdDate', 'updatedDate','specialization','program','cname'], 'safe'],
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
    public function search($params,$uid=null)
    {
        $query = UniversityCourse::find()->joinWith(['courseP']);
        if($uid!=null){
            $query->where(['universityID'=>$uid]);
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
            'universityID' => $this->universityID,
            'courseID' => $this->courseID,
            'createdDate' => $this->createdDate,
            'updatedDate' => $this->updatedDate,
            'status' => $this->status,
            'createdBy' => $this->createdBy,
            'updatedBy' => $this->updatedBy,
        ]);

        $query->andFilterWhere(['like', 'courses.name', $this->cname])
            ->andFilterWhere(['like', 'program.name', $this->program])
            ->andFilterWhere(['like', 'specialization.name', $this->specialization]);

        return $dataProvider;
    }
}

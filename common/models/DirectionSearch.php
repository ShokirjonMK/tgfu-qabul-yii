<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Direction;

/**
 * DirectionSearch represents the model behind the search form of `common\models\Direction`.
 */
class DirectionSearch extends Direction
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'edu_year_id', 'language_id', 'edu_year_type_id', 'edu_year_form_id', 'edu_form_id', 'edu_type_id', 'contract', 'oferta', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['name_uz', 'edu_duration', 'name_ru', 'name_en', 'code', 'course_json'], 'safe'],
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
        $query = Direction::find()
            ->where(['is_deleted' => 0])
            ->orderBy('id desc');

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
            'edu_year_id' => $this->edu_year_id,
            'language_id' => $this->language_id,
            'edu_year_type_id' => $this->edu_year_type_id,
            'edu_year_form_id' => $this->edu_year_form_id,
            'edu_duration' => $this->edu_duration,
            'edu_form_id' => $this->edu_form_id,
            'edu_type_id' => $this->edu_type_id,
            'contract' => $this->contract,
            'oferta' => $this->oferta,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'name_uz', $this->name_uz])
            ->andFilterWhere(['like', 'name_ru', $this->name_ru])
            ->andFilterWhere(['like', 'name_en', $this->name_en])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'course_json', $this->course_json]);

        return $dataProvider;
    }
}
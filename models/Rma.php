<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RmaT;

/**
 * Rma represents the model behind the search form of `app\models\RmaT`.
 */
class Rma extends RmaT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rma', 'size', 'id_user', 'konsumen'], 'integer'],
            [['rma_status', 'rma_nota', 'nama_foto', 'type', 'url', 'rma_date'], 'safe'],
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
        $query = RmaT::find();

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
            'rma' => $this->rma,
            'size' => $this->size,
            'id_user' => $this->id_user,
            'konsumen' => $this->konsumen,
            'rma_date' => $this->rma_date,
        ]);

        $query->andFilterWhere(['like', 'rma_status', $this->rma_status])
            ->andFilterWhere(['like', 'rma_nota', $this->rma_nota])
            ->andFilterWhere(['like', 'nama_foto', $this->nama_foto])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}

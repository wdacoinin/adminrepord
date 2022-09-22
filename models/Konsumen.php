<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\KonsumenT;

/**
 * Konsumen represents the model behind the search form of `app\models\KonsumenT`.
 */
class Konsumen extends KonsumenT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['konsumen'], 'integer'],
            [['konsumen_nama', 'konsumen_telp', 'alamat', 'timestamp'], 'safe'],
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
        $query = KonsumenT::find();

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
            'konsumen' => $this->konsumen,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'konsumen_nama', $this->konsumen_nama])
            ->andFilterWhere(['like', 'konsumen_telp', $this->konsumen_telp])
            ->andFilterWhere(['like', 'alamat', $this->alamat]);

        return $dataProvider;
    }
}

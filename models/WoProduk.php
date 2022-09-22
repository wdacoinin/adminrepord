<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WoProdukT;

/**
 * WoProduk represents the model behind the search form of `app\models\WoProdukT`.
 */
class WoProduk extends WoProdukT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wo_produk', 'wo', 'produk', 'do_produk', 'wo_jml', 'wo_hpp', 'wo_harga', 'user_input'], 'integer'],
            [['timestamp'], 'safe'],
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
        $query = WoProdukT::find();

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
            'wo_produk' => $this->wo_produk,
            'wo' => $this->wo,
            'produk' => $this->produk,
            'do_produk' => $this->do_produk,
            'wo_jml' => $this->wo_jml,
            'wo_hpp' => $this->wo_hpp,
            'wo_harga' => $this->wo_harga,
            'user_input' => $this->user_input,
            'timestamp' => $this->timestamp,
        ]);

        return $dataProvider;
    }
}

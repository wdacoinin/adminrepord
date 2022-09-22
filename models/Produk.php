<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProdukT;

/**
 * Produk represents the model behind the search form of `app\models\ProdukT`.
 */
class Produk extends ProdukT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produk', 'kategori', 'merek'], 'integer'],
            [['nama', 'status'], 'safe'],
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
        $query = ProdukT::find();

        // add conditions that should always apply here
        $query->joinWith(['kategori0', 'merek0']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['kategori0'] = [
            'asc' => ['kategori0.kategori_nama' => SORT_ASC],
            'desc' => ['kategori0.kategori_nama' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['merek0'] = [
            'asc' => ['merek0.nama' => SORT_ASC],
            'desc' => ['merek0.nama' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'produk' => $this->produk,
            'kategori.kategori' => $this->kategori,
            'merek.merek' => $this->merek,
        ]);

        $query->andFilterWhere(['like', 'produk.nama', $this->nama])
            ->andFilterWhere(['like', 'produk.status', $this->status]);

        return $dataProvider;
    }
}

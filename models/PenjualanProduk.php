<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PenjualanProdukT;

/**
 * PenjualanProduk represents the model behind the search form of `app\models\PenjualanProdukT`.
 */
class PenjualanProduk extends PenjualanProdukT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan_produk', 'penjualan', 'produk', 'do_produk', 'penjualan_jml', 'penjualan_hpp', 'penjualan_harga', 'retur_qty'], 'integer'],
            [['retur_date', 'timestamp'], 'safe'],
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
        $query = PenjualanProdukT::find();

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
            'penjualan_produk' => $this->penjualan_produk,
            'penjualan' => $this->penjualan,
            'produk' => $this->produk,
            'do_produk' => $this->do_produk,
            'penjualan_jml' => $this->penjualan_jml,
            'penjualan_hpp' => $this->penjualan_hpp,
            'penjualan_harga' => $this->penjualan_harga,
            'retur_qty' => $this->retur_qty,
            'retur_date' => $this->retur_date,
            'timestamp' => $this->timestamp,
        ]);

        return $dataProvider;
    }
}

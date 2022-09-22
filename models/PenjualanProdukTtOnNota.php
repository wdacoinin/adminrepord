<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PenjualanProdukTtT;

/**
 * PenjualanProdukTt represents the model behind the search form of `app\models\PenjualanProdukTtT`.
 */
class PenjualanProdukTtOnNota extends PenjualanProdukTtT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan_produk_tt', 'penjualan', 'produk', 'do_produk', 'do_jml', 'do_hpp', 'do_harga', 'user_input'], 'integer'],
            [['tt_date'], 'safe'],
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
    public function search($params, $penjualan)
    {
        $query = PenjualanProdukTtT::find()->where(['penjualan' => $penjualan]);

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
            'penjualan_produk_tt' => $this->penjualan_produk_tt,
            'penjualan' => $this->penjualan,
            'produk' => $this->produk,
            'do_produk' => $this->do_produk,
            'do_jml' => $this->do_jml,
            'do_hpp' => $this->do_hpp,
            'do_harga' => $this->do_harga,
            'user_input' => $this->user_input,
            'tt_date' => $this->tt_date,
        ]);

        return $dataProvider;
    }
}

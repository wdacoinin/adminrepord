<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Stokterjualv;

/**
 * Stokterjual represents the model behind the search form of `app\models\Stokterjualv`.
 */
class Stokterjual extends Stokterjualv
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan_produk', 'penjualan', 'penjualan_jml', 'do', 'produk', 'do_produk', 'do_jml', 'jml_now', 'rakitan', 'do_produk_origin', 'penjualan_harga'], 'integer'],
            [['batch', 'faktur', 'penjualan_tgl', 'produk_nama', 'kategori_nama', 'nama', 'stok_jenis_nama', 'kode', 'faktur_do', 'url'], 'safe'],
            [['do_harga', 'harga_jual'], 'number'],
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
        $query = Stokterjualv::find()->orderBy('penjualan_produk DESC');

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
            //'batch' => $this->batch,
            'penjualan' => $this->penjualan,
            'penjualan_jml' => $this->penjualan_jml,
            'penjualan_harga' => $this->penjualan_harga,
            //'penjualan_tgl' => $this->penjualan_tgl,
            'do' => $this->do,
            'produk' => $this->produk,
            'do_produk' => $this->do_produk,
            'do_jml' => $this->do_jml,
            'jml_now' => $this->jml_now,
            'do_harga' => $this->do_harga,
            'harga_jual' => $this->harga_jual,
            'do_produk_origin' => $this->do_produk_origin,
        ]);

        $query->andFilterWhere(['like', 'faktur', $this->faktur])
            ->andFilterWhere(['like', 'batch', $this->batch])
            ->andFilterWhere(['like', 'produk_nama', $this->produk_nama])
            ->andFilterWhere(['like', 'kategori_nama', $this->kategori_nama])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'stok_jenis_nama', $this->stok_jenis_nama])
            ->andFilterWhere(['like', 'kode', $this->kode])
            ->andFilterWhere(['like', 'faktur_do', $this->faktur_do])
            ->andFilterWhere(['like', 'url', $this->url]);

            if (!is_null($this->penjualan_tgl) && strpos($this->penjualan_tgl, ' - ') !== false ) {
    
                list($start_date, $end_date) = explode(' - ', $this->penjualan_tgl);
    
                $query->andFilterWhere(['between', 'penjualan_tgl', $start_date, $end_date]);
    
            }

        return $dataProvider;
    }
}

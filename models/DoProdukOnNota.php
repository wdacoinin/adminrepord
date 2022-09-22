<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DoProdukT;

/**
 * DoProduk represents the model behind the search form of `app\models\DoProdukT`.
 */
class DoProdukOnNota extends DoProdukT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['do_produk', 'do', 'stok_jenis', 'produk', 'do_jml', 'do_produk_status', 'jml_now', 'inventori', 'size'], 'integer'],
            [['do_harga', 'harga_jual'], 'number'],
            [['kategori_nama', 'nama_foto', 'type', 'url'], 'string'],
            [['do_produk_date', 'do_produk_date_stok', 'timestamp'], 'safe'],
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
    public function search($params, $do)
    {
        $query = DoProdukT::find()->where(['do' => $do, 'do_produk_origin' => 0])->andWhere('do_jml > 0');

        // add conditions that should always apply here
        $query->joinWith(['produk0', 'stokJenis']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['produk0'] = [
            'asc' => ['produk0.nama' => SORT_ASC],
            'desc' => ['produk0.nama' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['stokJenis'] = [
            'asc' => ['stokJenis.stok_jenis_nama' => SORT_ASC],
            'desc' => ['stokJenis.stok_jenis_nama' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'do_produk' => $this->do_produk,
            'do' => $this->do,
            'stok_jenis' => $this->stok_jenis,
            'produk' => $this->produk,
            'do_jml' => $this->do_jml,
            'do_harga' => $this->do_harga,
            'harga_jual' => $this->harga_jual,
            'do_produk_status' => $this->do_produk_status,
            'jml_now' => $this->jml_now,
            'do_produk_date' => $this->do_produk_date,
            'do_produk_date_stok' => $this->do_produk_date_stok,
            'timestamp' => $this->timestamp,
        ]);

        return $dataProvider;
    }
}

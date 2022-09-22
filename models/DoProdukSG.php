<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DoProdukT;

/**
 * DoProduk represents the model behind the search form of `app\models\DoProdukT`.
 */
class DoProdukSG extends DoProdukT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['do_produk', 'do', 'stok_jenis', 'produk', 'do_jml', 'do_produk_status', 'jml_now', 'inventori', 'size'], 'integer'],
            [['do_harga', 'harga_jual'], 'number'],
            [['kategori_nama', 'merek_nama', 'nama_foto', 'type', 'url', 'batch'], 'string'],
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
    public function search($params)
    {
        $query = DoProdukT::find()
        ->select('do_produk.*, dopo.batch, kategori.kategori_nama, merek.nama AS merek_nama')
        ->join("LEFT JOIN", "kategori", "produk.kategori=kategori.kategori")
        ->join("LEFT JOIN", "(SELECT dopo.do_produk, CASE WHEN dopo.do_produk_origin > 0 THEN CONCAT(dopo.produk, '-', dopo.do_produk_origin)
        ELSE CONCAT(dopo.produk, '-', dopo.do_produk) END AS batch FROM do_produk AS dopo) AS dopo", "dopo.do_produk=do_produk.do_produk")
        ->join("LEFT JOIN", "merek", "produk.merek=merek.merek")
        ->where('do_produk.jml_now > 0 AND do_produk.do_produk_status <> 2')
        ->orderBy('do_produk.do_produk DESC');


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
            'stok_jenis.stok_jenis' => $this->stok_jenis,
            'produk.produk' => $this->produk,
            'do_jml' => $this->do_jml,
            'do_harga' => $this->do_harga,
            'inventori' => $this->inventori,
            'harga_jual' => $this->harga_jual,
            'do_produk_status' => $this->do_produk_status,
            'jml_now' => $this->jml_now,
            'do_produk_date' => $this->do_produk_date,
            'do_produk_date_stok' => $this->do_produk_date_stok,
            'timestamp' => $this->timestamp,
            'kategori_nama' => $this->kategori_nama,
            'merek.nama' => $this->merek_nama,
        ]);

        $query->andFilterWhere(['like', 'dopo.batch',  $this->batch]);

        return $dataProvider;
    }
}

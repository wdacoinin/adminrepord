<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RakitanT;

/**
 * Rakitan represents the model behind the search form of `app\models\RakitanT`.
 */
class Rakitan extends RakitanT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rakitan', 'inventori', 'penjualan', 'size', 'id_user', 'rakitan_order', 'harga_jual'], 'integer'],
            [['status', 'nama_foto', 'type', 'url', 'rakitan_date'], 'safe'],
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
        $query = RakitanT::find()
        ->select([
        'rakitan.*',
        'do_produk.harga_jual'
        ])
        ->join("LEFT JOIN", "(SELECT do_produk.rakitan, SUM(do_produk.do_jml*do_produk.harga_jual) AS `harga_jual` FROM do_produk AS do_produk GROUP BY do_produk.rakitan) AS do_produk", "do_produk.rakitan=rakitan.rakitan")
        //->join("LEFT JOIN", "penjualan", "penjualan.penjualan=rakitan.penjualan")
        ->where('rakitan.penjualan IS NULL')
        ->groupBy('rakitan.rakitan');
        //->join("LEFT JOIN", "do_produk", "rakitan.rakitan=do_produk.do_produk")
        //->join("LEFT JOIN", "kategori", "produk.kategori=kategori.kategori");

        // add conditions that should always apply here
        $query->joinWith(['user', 'penjualan0']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['user'] = [
            'asc' => ['user.nama' => SORT_ASC],
            'desc' => ['user.nama' => SORT_DESC],
        ];

        /* $dataProvider->sort->attributes['penjualan0'] = [
            'asc' => ['penjualan0.faktur' => SORT_ASC],
            'desc' => ['penjualan0.faktur' => SORT_DESC],
        ]; */

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'rakitan' => $this->rakitan,
            'inventori' => $this->inventori,
            'penjualan' => $this->penjualan,
            'id_user' => $this->id_user,
            'rakitan_order' => $this->rakitan_order,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            //->andFilterWhere(['like', 'penjualan.faktur', $this->faktur])
            ->andFilterWhere(['like', 'nama_foto', $this->nama_foto])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'harga_jual', $this->harga_jual])
            ->andFilterWhere(['like', 'url', $this->url]);


        if (!is_null($this->rakitan_date) && strpos($this->rakitan_date, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->rakitan_date);

            $query->andFilterWhere(['between', 'rakitan_date', $start_date, $end_date]);

        }

        return $dataProvider;
    }
}

<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PenjualanT;

/**
 * Penjualan represents the model behind the search form of `app\models\PenjualanT`.
 */
class Penjualan extends PenjualanT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan', 'konsumen', 'penjualan_ongkir', 'fee', 'sales', 'penjualan_diskon', 'user', 'akun', 'total_bahan'], 'integer'],
            [['penjualan_tgl', 'penjualan_tempo', 'faktur', 'surat_jalan', 'keterangan', 'fee_date', 'penjualan_status', 'penjualan_type'], 'safe'],
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
        $query = PenjualanT::find();

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
            'penjualan' => $this->penjualan,
            /* 'penjualan_tgl' => $this->penjualan_tgl, */
            'penjualan_tempo' => $this->penjualan_tempo,
            'konsumen' => $this->konsumen,
            'penjualan_ongkir' => $this->penjualan_ongkir,
            'fee' => $this->fee,
            'fee_date' => $this->fee_date,
            'sales' => $this->sales,
            'penjualan_diskon' => $this->penjualan_diskon,
            'user' => $this->user,
            'akun' => $this->akun,
            'total_bahan' => $this->total_bahan,
        ]);

        $query->andFilterWhere(['like', 'faktur', $this->faktur])
            ->andFilterWhere(['like', 'surat_jalan', $this->surat_jalan])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'penjualan_status', $this->penjualan_status]);


        if (!is_null($this->penjualan_tgl) && strpos($this->penjualan_tgl, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->penjualan_tgl);

            $query->andFilterWhere(['between', 'penjualan_tgl', $start_date, $end_date]);

        }
        return $dataProvider;
    }
}

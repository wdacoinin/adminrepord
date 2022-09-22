<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Penjualanv;

/**
 * Penjualan represents the model behind the search form of `app\models\PenjualanT`.
 */
class Penjualans extends Penjualanv
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan', 'penjualan_ongkir', 'penjualan_diskon'], 'integer'],
            [['penjualan_tgl', 'faktur', 'penjualan_status'], 'string'],
            [['penjualan_tgl'], 'safe'],
            [['total', 'ppn', 'total_plus_ppn', 'total_bayar'], 'number'],
            [['konsumen_nama', 'faktur', 'surat_jalan'], 'string', 'max' => 255],
            [['penjualan_status'], 'string', 'max' => 20],
            [['penjualan_type'], 'string', 'max' => 50],
            [['sales'], 'string', 'max' => 150],
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
        $query = Penjualanv::find()->orderBy('penjualan DESC');

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
            /* 'faktur' => $this->faktur,
            'penjualan_tempo' => $this->penjualan_tempo,
            'akun' => $this->akun, */
            //'konsumen_nama' => $this->konsumen_nama,
            'penjualan_ongkir' => $this->penjualan_ongkir,
            //'sales' => $this->sales,
            'penjualan_diskon' => $this->penjualan_diskon,
        ]);

        $query->andFilterWhere(['like', 'faktur', $this->faktur])
        ->andFilterWhere(['like', 'konsumen_nama', $this->konsumen_nama])
        ->andFilterWhere(['like', 'sales', $this->sales])
            ->andFilterWhere(['like', 'penjualan_status', $this->penjualan_status]);


        if (!is_null($this->penjualan_tgl) && strpos($this->penjualan_tgl, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->penjualan_tgl);

            $query->andFilterWhere(['between', 'penjualan_tgl', $start_date, $end_date]);

        }
        return $dataProvider;
    }
}

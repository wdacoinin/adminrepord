<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dopembelianv;

/**
 * Dopembelian represents the model behind the search form of `app\models\Dopembelianv`.
 */
class Dopembelian extends Dopembelianv
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['do'], 'integer'],
            [['do_tgl', 'supplier_nama', 'faktur', 'do_status', 'do_tempo', 'no_sj', 'nama'], 'safe'],
            [['do_diskon', 'total', 'ppn', 'total_plus_ppn', 'total_bayar'], 'number'],
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
        $query = Dopembelianv::find()->orderBy('do_tgl DESC');

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
            'do' => $this->do,
            'faktur' => $this->faktur,
            /* 'do_tgl' => $this->do_tgl, */
            'do_tempo' => $this->do_tempo,
            'do_diskon' => $this->do_diskon,
            'total' => $this->total,
            'ppn' => $this->ppn,
            'do_status' => $this->do_status,
            'supplier_nama' => $this->supplier_nama,
            'total_plus_ppn' => $this->total_plus_ppn,
            'total_bayar' => $this->total_bayar,
        ]);

        $query->andFilterWhere(['like', 'no_sj', $this->no_sj])
            ->andFilterWhere(['like', 'nama', $this->nama]);


        if (!is_null($this->do_tgl) && strpos($this->do_tgl, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->do_tgl);

            $query->andFilterWhere(['between', 'do_tgl', $start_date, $end_date]);

        }

        return $dataProvider;
    }
}

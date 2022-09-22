<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DopT;

/**
 * Dop represents the model behind the search form of `app\models\DopT`.
 */
class Dop extends DopT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['do', 'supplier', 'us', 'ppn'], 'integer'],
            [['do_tgl', 'do_status', 'faktur', 'do_tempo', 'no_sj', 'keterangan'], 'safe'],
            [['do_diskon'], 'number'],
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
        $query = DopT::find();

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
            /* 'do_tgl' => $this->do_tgl, */
            'supplier' => $this->supplier,
            'us' => $this->us,
            'do_tempo' => $this->do_tempo,
            'do_diskon' => $this->do_diskon,
            'ppn' => $this->ppn,
        ]);

        $query->andFilterWhere(['like', 'do_status', $this->do_status])
            ->andFilterWhere(['like', 'faktur', $this->faktur])
            ->andFilterWhere(['like', 'no_sj', $this->no_sj])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);


        if (!is_null($this->do_tgl) && strpos($this->do_tgl, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->do_tgl);

            $query->andFilterWhere(['between', 'do_tgl', $start_date, $end_date]);

        }

        return $dataProvider;
    }
}

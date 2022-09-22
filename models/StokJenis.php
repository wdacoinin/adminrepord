<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StokJenisT;

/**
 * StokJenis represents the model behind the search form of `app\models\StokJenisT`.
 */
class StokJenis extends StokJenisT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['stok_jenis', 'stok_jenis_status'], 'integer'],
            [['stok_jenis_nama'], 'safe'],
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
        $query = StokJenisT::find();

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
            'stok_jenis' => $this->stok_jenis,
            'stok_jenis_status' => $this->stok_jenis_status,
        ]);

        $query->andFilterWhere(['like', 'stok_jenis_nama', $this->stok_jenis_nama]);

        return $dataProvider;
    }
}

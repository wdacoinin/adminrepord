<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BebanJenisT;

/**
 * BebanJenis represents the model behind the search form of `app\models\BebanJenisT`.
 */
class BebanJenis extends BebanJenisT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['beban_jenis', 'status'], 'integer'],
            [['beban_jenis_nama'], 'safe'],
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
        $query = BebanJenisT::find();

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
            'beban_jenis' => $this->beban_jenis,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'beban_jenis_nama', $this->beban_jenis_nama]);

        return $dataProvider;
    }
}

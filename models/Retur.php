<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReturT;

/**
 * Retur represents the model behind the search form of `app\models\ReturT`.
 */
class Retur extends ReturT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['retur', 'do', 'user', 'retur_status', 'size'], 'integer'],
            [['noretur', 'date', 'nama_foto', 'type', 'keterangan', 'url'], 'safe'],
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
        $query = ReturT::find();

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
            'retur' => $this->retur,
            'do' => $this->do,
            'date' => $this->date,
            'user' => $this->user,
            'retur_status' => $this->retur_status,
            'size' => $this->size,
        ]);

        $query->andFilterWhere(['like', 'noretur', $this->noretur])
            ->andFilterWhere(['like', 'nama_foto', $this->nama_foto])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}

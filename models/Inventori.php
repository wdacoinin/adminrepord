<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InventoriT;

/**
 * Inventori represents the model behind the search form of `app\models\InventoriT`.
 */
class Inventori extends InventoriT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inventori', 'lokasi'], 'integer'],
            [['kode'], 'safe'],
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
        $query = InventoriT::find();

        // add conditions that should always apply here
        $query->joinWith(['lokasi0']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['lokasi0'] = [
            'asc' => ['lokasi0.nama' => SORT_ASC],
            'desc' => ['lokasi0.nama' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'inventori' => $this->inventori,
            'lokasi.lokasi' => $this->lokasi,
        ]);

        $query->andFilterWhere(['like', 'kode', $this->kode]);

        return $dataProvider;
    }
}

<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BebanT;

/**
 * Beban represents the model behind the search form of `app\models\BebanT`.
 */
class Beban extends BebanT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['beban', 'beban_jenis'], 'integer'],
            [['nama'], 'safe'],
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
        $query = BebanT::find();

        // add conditions that should always apply here
        $query->joinWith(['bebanJenis']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['bebanJenis'] = [
            'asc' => ['bebanJenis.beban_jenis_nama' => SORT_ASC],
            'desc' => ['bebanJenis.beban_jenis_nama' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'beban' => $this->beban,
            'bebanJenis.beban_jenis_nama' => $this->beban_jenis,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama]);

        return $dataProvider;
    }
}

<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VariableT;

/**
 * Variable represents the model behind the search form of `app\models\VariableT`.
 */
class Variable extends VariableT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['variable', 'divisi', 'val'], 'integer'],
            [['nama', 'detail', 'status'], 'safe'],
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
        $query = VariableT::find();

        // add conditions that should always apply here
        $query->joinWith(['divisi0']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['divisi0'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['divisi0.nama' => SORT_ASC],
            'desc' => ['divisi0.nama' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'variable' => $this->variable,
            //'divisi' => $this->divisi,
            'val' => $this->val,
            //'user.divisi' => $this->divisi,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'detail', $this->detail])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}

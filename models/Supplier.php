<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SupplierT;

/**
 * Supplier represents the model behind the search form of `app\models\SupplierT`.
 */
class Supplier extends SupplierT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['supplier'], 'integer'],
            [['supplier_nama', 'supplier_detail'], 'safe'],
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
        $query = SupplierT::find();

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
            'supplier' => $this->supplier,
        ]);

        $query->andFilterWhere(['like', 'supplier_nama', $this->supplier_nama])
            ->andFilterWhere(['like', 'supplier_detail', $this->supplier_detail]);

        return $dataProvider;
    }
}

<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RmaItemT;

/**
 * RmaItem represents the model behind the search form of `app\models\RmaItemT`.
 */
class RmaItem extends RmaItemT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rma_item', 'rma', 'produk', 'rma_jml', 'rma_harga', 'size', 'id_user'], 'integer'],
            [['rma_ket', 'nama_foto', 'type', 'url', 'timestamp'], 'safe'],
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
    public function search($params, $rma)
    {
        $query = RmaItemT::find()->where(['rma' => $rma]);

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
            'rma_item' => $this->rma_item,
            'rma' => $this->rma,
            'produk' => $this->produk,
            'rma_jml' => $this->rma_jml,
            'rma_harga' => $this->rma_harga,
            'size' => $this->size,
            'id_user' => $this->id_user,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'rma_ket', $this->rma_ket])
            ->andFilterWhere(['like', 'nama_foto', $this->nama_foto])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}

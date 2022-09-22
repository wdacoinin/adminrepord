<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Produkv;

/**
 * Produk represents the model behind the search form of `app\models\ProdukT`.
 */
class Produkvs extends Produkv
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produk', 'kategori', 'merek', 'jml_now', 'jml_retur'], 'integer'],
            [['nama', 'merek_nama', 'kategori_nama', 'status'], 'safe'],
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
        $query = Produkv::find()->orderBy(['kategori_nama' => SORT_ASC]);

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
            'produk' => $this->produk,
            'kategori_nama' => $this->kategori_nama,
            'merek_nama' => $this->merek_nama,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
        ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}

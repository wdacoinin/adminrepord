<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\KategoriT;

/**
 * Kategori represents the model behind the search form of `app\models\KategoriT`.
 */
class Kategori extends KategoriT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kategori', 'kategori_urutan'], 'integer'],
            [['kategori_nama'], 'string', 'max' => 255],
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
        $query = KategoriT::find()->orderBy('kategori_urutan ASC');

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
            'kategori' => $this->kategori,
            'kategori_urutan' => $this->kategori_urutan,
        ]);

        $query->andFilterWhere(['like', 'kategori_nama', $this->kategori_nama]);

        return $dataProvider;
    }
}

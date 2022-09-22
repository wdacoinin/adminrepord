<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AkunT;

/**
 * Akun represents the model behind the search form of `app\models\AkunT`.
 */
class Akun extends AkunT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['akun', 'akun_owner'], 'integer'],
            [['akun_nama', 'an', 'akun_ref', 'akun_type'], 'safe'],
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
        $query = AkunT::find();

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
            'akun' => $this->akun,
            'akun_owner' => $this->akun_owner,
        ]);

        $query->andFilterWhere(['like', 'akun_nama', $this->akun_nama])
            ->andFilterWhere(['like', 'an', $this->an])
            ->andFilterWhere(['like', 'akun_ref', $this->akun_ref])
            ->andFilterWhere(['like', 'akun_type', $this->akun_type]);

        return $dataProvider;
    }
}

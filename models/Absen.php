<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AbsenT;

/**
 * Absen represents the model behind the search form of `app\models\AbsenT`.
 */
class Absen extends AbsenT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['absen', 'id', 'size'], 'integer'],
            [['datetime', 'nama_foto', 'type', 'url', 'lat', 'lon'], 'safe'],
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
        $query = AbsenT::find()->orderBy('absen DESC');

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
            'absen' => $this->absen,
            'id' => $this->id,
            //'datetime' => $this->datetime,
            'size' => $this->size,
        ]);

        $query->andFilterWhere(['like', 'nama_foto', $this->nama_foto])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'lat', $this->lat])
            ->andFilterWhere(['like', 'lon', $this->lon]);


        if (!is_null($this->datetime) && strpos($this->datetime, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->datetime);

            $query->andFilterWhere(['between', 'datetime', $start_date, $end_date]);

        }

        return $dataProvider;
    }
}

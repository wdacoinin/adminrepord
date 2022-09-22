<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PengirimanT;

/**
 * Pengiriman represents the model behind the search form of `app\models\PengirimanT`.
 */
class PengirimanM extends PengirimanT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pengiriman', 'user', 'size'], 'integer'],
            [['surat_jalan', 'nama_penerima', 'cp', 'Alamat', 'datetime', 'nama_foto', 'type', 'url', 'lat', 'lon'], 'safe'],
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
    public function search($params, $user)
    {
        $query = PengirimanT::find()->where(['user' => $user])->andWhere('lat IS NULL');

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
            'pengiriman' => $this->pengiriman,
            'user' => $this->user,
            //'datetime' => $this->datetime,
            'size' => $this->size,
        ]);

        $query->andFilterWhere(['like', 'surat_jalan', $this->surat_jalan])
            ->andFilterWhere(['like', 'nama_penerima', $this->nama_penerima])
            ->andFilterWhere(['like', 'cp', $this->cp])
            ->andFilterWhere(['like', 'Alamat', $this->Alamat])
            ->andFilterWhere(['like', 'nama_foto', $this->nama_foto])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'url', $this->url]);


            if (!is_null($this->datetime) && strpos($this->datetime, ' - ') !== false ) {
    
                list($start_date, $end_date) = explode(' - ', $this->datetime);
    
                $query->andFilterWhere(['between', 'datetime', $start_date, $end_date]);
    
            }

        return $dataProvider;
    }
}

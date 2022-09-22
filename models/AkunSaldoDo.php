<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AkunSaldoT;

/**
 * AkunSaldo represents the model behind the search form of `app\models\AkunSaldoT`.
 */
class AkunSaldoDo extends AkunSaldoT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['akun_saldo', 'aktiva', 'akun', 'noref', 'user', 'size'], 'integer'],
            [['ket', 'notrans', 'datetime', 'nama_foto', 'type', 'url'], 'safe'],
            [['jml'], 'number'],
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
    public function search($params, $aktiva, $noref)
    {
        $query = AkunSaldoT::find()->where(['akun_saldo.aktiva' => $aktiva, 'akun_saldo.noref' => $noref])->orderBy('datetime ASC');

        // add conditions that should always apply here
        $query->joinWith(['user0', 'akun0', 'aktiva0']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['user0'] = [
            'asc' => ['user0.nama' => SORT_ASC],
            'desc' => ['user0.nama' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['akun0'] = [
            'asc' => ['akun0.akun_ref' => SORT_ASC],
            'desc' => ['akun0.akun_ref' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['aktiva0'] = [
            'asc' => ['aktiva0.aktiva_nama' => SORT_ASC],
            'desc' => ['aktiva0.aktiva_nama' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'akun_saldo' => $this->akun_saldo,
            'aktiva.aktiva' => $this->aktiva,
            'akun.akun' => $this->akun,
            'noref' => $this->noref,
            'notrans' => $this->notrans,
            'jml' => $this->jml,
            'datetime' => $this->datetime,
            'user.id' => $this->user,
            'size' => $this->size,
        ]);

        $query->andFilterWhere(['like', 'ket', $this->ket])
            ->andFilterWhere(['like', 'nama_foto', $this->nama_foto])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}

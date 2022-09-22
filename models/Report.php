<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReportT;

/**
 * Report represents the model behind the search form of `app\models\ReportT`.
 */
class Report extends ReportT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['report', 'report_user', 'report_status'], 'integer'],
            [['report_detail', 'report_date'], 'safe'],
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
        $query = ReportT::find();

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
            'report' => $this->report,
            'report_user' => $this->report_user,
            'report_date' => $this->report_date,
            'report_status' => $this->report_status,
        ]);

        $query->andFilterWhere(['like', 'report_detail', $this->report_detail]);

        return $dataProvider;
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "report".
 *
 * @property int $report
 * @property string $report_detail
 * @property int $report_user
 * @property string $report_date
 * @property int $report_status 1.Report, 2.Selesai
 *
 * @property User $reportUser
 */
class ReportT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['report_detail', 'report_user', 'report_date'], 'required'],
            [['report_detail'], 'string'],
            [['report_user', 'report_status'], 'integer'],
            [['report_date'], 'safe'],
            [['report_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['report_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'report' => 'Report',
            'report_detail' => 'Report Detail',
            'report_user' => 'Report User',
            'report_date' => 'Report Date',
            'report_status' => 'Report Status',
        ];
    }

    /**
     * Gets query for [[ReportUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReportUser()
    {
        return $this->hasOne(User::className(), ['id' => 'report_user']);
    }
}

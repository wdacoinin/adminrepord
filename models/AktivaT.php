<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "aktiva".
 *
 * @property int $aktiva
 * @property string $aktiva_nama
 * @property string $d_k
 * @property int $status
 *
 * @property AkunSaldo[] $akunSaldos
 */
class AktivaT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aktiva';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aktiva_nama', 'd_k', 'status'], 'required'],
            [['status'], 'integer'],
            [['aktiva_nama'], 'string', 'max' => 255],
            [['d_k'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'aktiva' => 'Akun',
            'aktiva_nama' => 'Akun Nama',
            'd_k' => 'D/K',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[AkunSaldos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAkunSaldos()
    {
        return $this->hasMany(AkunSaldo::className(), ['aktiva' => 'aktiva']);
    }
}

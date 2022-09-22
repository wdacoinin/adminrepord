<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "konsumen".
 *
 * @property int $konsumen
 * @property string $konsumen_nama
 * @property string|null $konsumen_telp
 * @property string|null $alamat
 * @property string $timestamp
 *
 * @property Penjualan[] $penjualans
 */
class KonsumenT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'konsumen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['konsumen_nama'], 'required'],
            [['alamat'], 'string'],
            [['timestamp'], 'safe'],
            [['konsumen_nama'], 'string', 'max' => 255],
            [['konsumen_telp'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'konsumen' => 'Konsumen',
            'konsumen_nama' => 'Konsumen Nama',
            'konsumen_telp' => 'Konsumen Telp',
            'alamat' => 'Alamat',
            'timestamp' => 'Tgl.terdaftar',
        ];
    }

    /**
     * Gets query for [[Penjualans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualans()
    {
        return $this->hasMany(Penjualan::className(), ['konsumen' => 'konsumen']);
    }
}

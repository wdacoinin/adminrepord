<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inventori".
 *
 * @property int $inventori
 * @property int $lokasi
 * @property string $kode
 *
 * @property DoProduk[] $doProduks
 * @property Lokasi $lokasi0
 * @property Rakitan[] $rakitans
 */
class InventoriT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inventori';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lokasi', 'kode'], 'required'],
            [['lokasi'], 'integer'],
            [['kode'], 'string', 'max' => 255],
            [['lokasi'], 'exist', 'skipOnError' => true, 'targetClass' => Lokasi::className(), 'targetAttribute' => ['lokasi' => 'lokasi']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'inventori' => 'Inventori',
            'lokasi' => 'Lokasi',
            'kode' => 'Kode',
        ];
    }

    /**
     * Gets query for [[DoProduks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDoProduks()
    {
        return $this->hasMany(DoProduk::className(), ['inventori' => 'inventori']);
    }

    /**
     * Gets query for [[Lokasi0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLokasi0()
    {
        return $this->hasOne(Lokasi::className(), ['lokasi' => 'lokasi']);
    }

    /**
     * Gets query for [[Rakitans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRakitans()
    {
        return $this->hasMany(Rakitan::className(), ['inventori' => 'inventori']);
    }
}

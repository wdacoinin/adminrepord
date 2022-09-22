<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produk".
 *
 * @property int $produk
 * @property string $nama
 * @property int $kategori
 * @property int $merek
 * @property string|null $status
 *
 * @property DoProduk[] $doProduks
 * @property Kategori $kategori0
 * @property MerekT $merek0
 * @property PenjualanProduk[] $penjualanProduks
 */
class ProdukT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'kategori', 'merek'], 'required'],
            [['produk', 'kategori', 'merek'], 'integer'],
            [['nama'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 50],
            [['produk'], 'unique'],
            [['kategori'], 'exist', 'skipOnError' => true, 'targetClass' => Kategori::className(), 'targetAttribute' => ['kategori' => 'kategori']],
            [['merek'], 'exist', 'skipOnError' => true, 'targetClass' => MerekT::className(), 'targetAttribute' => ['merek' => 'merek']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'produk' => 'Produk',
            'nama' => 'Nama',
            'kategori' => 'Kategori',
            'merek' => 'Merek',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[DoProduks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDoProduks()
    {
        return $this->hasMany(DoProduk::className(), ['produk' => 'produk']);
    }

    /**
     * Gets query for [[Kategori0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKategori0()
    {
        return $this->hasOne(Kategori::className(), ['kategori' => 'kategori']);
    }

    /**
     * Gets query for [[Merek0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMerek0()
    {
        return $this->hasOne(MerekT::className(), ['merek' => 'merek']);
    }

    /**
     * Gets query for [[PenjualanProduks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualanProduks()
    {
        return $this->hasMany(PenjualanProduk::className(), ['produk' => 'produk']);
    }
}

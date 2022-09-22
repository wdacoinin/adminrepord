<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rma_item".
 *
 * @property int $rma_item
 * @property int $rma
 * @property int $produk
 * @property int $rma_jml
 * @property int $rma_harga
 * @property int $merek
 * @property string|null $rma_ket
 * @property string|null $nama_foto
 * @property string|null $type
 * @property int|null $size
 * @property string|null $url
 * @property int $id_user
 * @property string $timestamp
 *
 * @property Produk $produk0
 * @property Rma $rma0
 */
class RmaItemT extends \yii\db\ActiveRecord
{
    public $merek;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rma_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rma', 'produk', 'rma_jml', 'rma_harga', 'id_user'], 'required'],
            [['rma', 'produk', 'rma_jml', 'rma_harga', 'size', 'id_user'], 'integer'],
            [['rma_ket'], 'string'],
            [['timestamp'], 'safe'],
            [['nama_foto', 'type', 'url'], 'string', 'max' => 255],
            [['rma'], 'exist', 'skipOnError' => true, 'targetClass' => Rma::className(), 'targetAttribute' => ['rma' => 'rma']],
            [['produk'], 'exist', 'skipOnError' => true, 'targetClass' => Produk::className(), 'targetAttribute' => ['produk' => 'produk']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rma_item' => 'Rma Item',
            'rma' => 'Rma',
            'produk' => 'Produk',
            'rma_jml' => 'Rma Jml',
            'rma_harga' => 'Rma Harga',
            'rma_ket' => 'Rma Ket',
            'nama_foto' => 'Nama Foto',
            'type' => 'Type',
            'size' => 'Size',
            'url' => 'Url',
            'id_user' => 'Id User',
            'timestamp' => 'Timestamp',
            'merek' => 'Merek',
        ];
    }

    /**
     * Gets query for [[Produk0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduk0()
    {
        return $this->hasOne(Produk::className(), ['produk' => 'produk']);
    }

    /**
     * Gets query for [[Rma0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRma0()
    {
        return $this->hasOne(Rma::className(), ['rma' => 'rma']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penjualan_produk".
 *
 * @property int $penjualan_produk
 * @property int $penjualan
 * @property int $produk
 * @property int|null $do_produk
 * @property int $penjualan_jml
 * @property int $penjualan_hpp
 * @property int $penjualan_harga
 * @property int $user_input
 * @property int|null $retur_qty
 * @property string|null $retur_date
 * @property string $timestamp
 * @property bool $sebatch
 * @property int $rakitan
 *
 * @property DoProduk $doProduk
 * @property Penjualan $penjualan0
 * @property Produk $produk0
 * @property User $userInput
 */
class PenjualanProdukT extends \yii\db\ActiveRecord
{
    public $sebatch;
    public $rakitan;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penjualan_produk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan', 'produk', 'penjualan_jml', 'penjualan_harga', 'user_input'], 'required'],
            [['penjualan', 'produk', 'do_produk', 'penjualan_jml', 'penjualan_hpp', 'penjualan_harga', 'user_input', 'retur_qty', 'rakitan'], 'integer'],
            [['retur_date', 'timestamp'], 'safe'],
            [['do_produk'], 'exist', 'skipOnError' => true, 'targetClass' => DoProduk::className(), 'targetAttribute' => ['do_produk' => 'do_produk']],
            [['penjualan'], 'exist', 'skipOnError' => true, 'targetClass' => Penjualan::className(), 'targetAttribute' => ['penjualan' => 'penjualan']],
            [['produk'], 'exist', 'skipOnError' => true, 'targetClass' => Produk::className(), 'targetAttribute' => ['produk' => 'produk']],
            [['user_input'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_input' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'penjualan_produk' => 'Penjualan Produk',
            'penjualan' => 'Penjualan',
            'produk' => 'Produk',
            'do_produk' => 'Do Produk',
            'penjualan_jml' => 'Penjualan Jml',
            'penjualan_hpp' => 'Penjualan Hpp',
            'penjualan_harga' => 'Penjualan Harga',
            'user_input' => 'User Input',
            'retur_qty' => 'Retur Qty',
            'retur_date' => 'Retur Date',
            'timestamp' => 'Timestamp',
            'sebatch' => 'Batch produk',
            'rakitan' => 'Rakitan',
        ];
    }

    /**
     * Gets query for [[DoProduk]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDoProduk()
    {
        return $this->hasOne(DoProduk::className(), ['do_produk' => 'do_produk']);
    }

    /**
     * Gets query for [[Penjualan0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualan0()
    {
        return $this->hasOne(Penjualan::className(), ['penjualan' => 'penjualan']);
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
     * Gets query for [[UserInput]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserInput()
    {
        return $this->hasOne(User::className(), ['id' => 'user_input']);
    }
}

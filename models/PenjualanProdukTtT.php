<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penjualan_produk_tt".
 *
 * @property int $penjualan_produk_tt
 * @property int $penjualan
 * @property int $produk
 * @property int|null $do_produk
 * @property int $do_jml
 * @property int $do_hpp
 * @property int $do_harga
 * @property int $user_input
 * @property int $inventori
 * @property string|null $tt_date
 *
 * @property DoProduk $doProduk
 * @property Penjualan $penjualan0
 * @property Produk $produk0
 * @property User $userInput
 */
class PenjualanProdukTtT extends \yii\db\ActiveRecord
{
    public $inventori;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penjualan_produk_tt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan', 'produk', 'do_jml', 'do_hpp', 'do_harga', 'user_input'], 'required'],
            [['penjualan', 'produk', 'do_produk', 'do_jml', 'do_hpp', 'do_harga', 'user_input', 'inventori'], 'integer'],
            [['tt_date'], 'safe'],
            [['penjualan'], 'exist', 'skipOnError' => true, 'targetClass' => Penjualan::className(), 'targetAttribute' => ['penjualan' => 'penjualan']],
            [['do_produk'], 'exist', 'skipOnError' => true, 'targetClass' => DoProduk::className(), 'targetAttribute' => ['do_produk' => 'do_produk']],
            [['user_input'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_input' => 'id']],
            [['produk'], 'exist', 'skipOnError' => true, 'targetClass' => Produk::className(), 'targetAttribute' => ['produk' => 'produk']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'penjualan_produk_tt' => 'Penjualan Produk Tt',
            'penjualan' => 'Penjualan',
            'produk' => 'Produk',
            'do_produk' => 'Do Produk',
            'do_jml' => 'Do Jml',
            'do_hpp' => 'Do Hpp',
            'do_harga' => 'Do Harga',
            'user_input' => 'User Input',
            'tt_date' => 'Tt Date',
            'inventori' => 'Lokasi',
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

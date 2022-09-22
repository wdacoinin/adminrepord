<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wo_produk".
 *
 * @property int $wo_produk
 * @property int $wo
 * @property int $produk
 * @property int|null $do_produk
 * @property int $wo_jml
 * @property int $wo_hpp
 * @property int $wo_harga
 * @property string $wo_produk_status
 * @property int $user_input
 * @property string $timestamp
 *
 * @property DoProduk $doProduk
 * @property WoT $wo0
 */
class WoProdukT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wo_produk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wo', 'produk', 'wo_jml', 'wo_harga', 'user_input'], 'required'],
            [['wo', 'produk', 'do_produk', 'wo_jml', 'wo_hpp', 'wo_harga', 'user_input'], 'integer'],
            [['wo_produk_status'], 'string'],
            [['timestamp'], 'safe'],
            [['wo'], 'exist', 'skipOnError' => true, 'targetClass' => WoT::className(), 'targetAttribute' => ['wo' => 'wo']],
            [['do_produk'], 'exist', 'skipOnError' => true, 'targetClass' => DoProduk::className(), 'targetAttribute' => ['do_produk' => 'do_produk']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'wo_produk' => 'Wo Produk',
            'wo' => 'Wo',
            'produk' => 'Produk',
            'do_produk' => 'Do Produk',
            'wo_jml' => 'Wo Jml',
            'wo_hpp' => 'Wo Hpp',
            'wo_harga' => 'Wo Harga',
            'wo_produk_status' => 'Status',
            'user_input' => 'User Input',
            'timestamp' => 'Timestamp',
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
     * Gets query for [[Wo0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWo0()
    {
        return $this->hasOne(WoT::className(), ['wo' => 'wo']);
    }
}

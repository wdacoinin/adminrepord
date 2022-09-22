<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rakitan".
 *
 * @property int $rakitan
 * @property int $inventori
 * @property string $status
 * @property int|null $penjualan
 * @property string|null $nama_foto
 * @property string|null $type
 * @property string|null $url
 * @property int|null $size
 * @property int|null $id_user
 * @property int|null $do_produk
 * @property int|null $jml_rakit
 * @property int|null $harga_jual
 * @property int|null $rakitan_order
 * @property string|null $faktur
 *
 * @property DoProduk[] $doProduks
 * @property Inventori $inventori0
 * @property Penjualan $penjualan0
 * @property User $user
 */
class RakitanT extends \yii\db\ActiveRecord
{
    public $do_produk;
    public $produk;
    public $merek;
    public $jml_rakit;
    public $harga_jual;
    public $faktur;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rakitan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inventori'], 'required'],
            [['inventori', 'penjualan', 'size', 'id_user', 'jml_rakit', 'do_produk', 'harga_jual', 'rakitan_order'], 'integer'],
            [['status', 'nama_foto', 'type', 'url', 'faktur'], 'string', 'max' => 255],
            [['rakitan_date'], 'safe'],
            [['inventori'], 'exist', 'skipOnError' => true, 'targetClass' => Inventori::className(), 'targetAttribute' => ['inventori' => 'inventori']],
            [['penjualan'], 'exist', 'skipOnError' => true, 'targetClass' => Penjualan::className(), 'targetAttribute' => ['penjualan' => 'penjualan']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rakitan' => 'Rakitan',
            'inventori' => 'Inventori',
            'status' => 'Status',
            'penjualan' => 'Penjualan',
            'nama_foto' => 'Nama Foto',
            'type' => 'Type',
            'url' => 'Url',
            'size' => 'Size',
            'id_user' => 'Id User',
            'jml_rakit' => 'Jml Rakit',
            'do_produk' => 'Do Produk',
            'harga_jual' => 'Set Harga Jual di rakitan',
            'rakitan_order' => 'By Order',
            'faktur' => 'Faktur'
        ];
    }

    /**
     * Gets query for [[DoProduks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDoProduks()
    {
        return $this->hasMany(DoProduk::className(), ['rakitan' => 'rakitan']);
    }

    /**
     * Gets query for [[Inventori0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInventori0()
    {
        return $this->hasOne(Inventori::className(), ['inventori' => 'inventori']);
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}

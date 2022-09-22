<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "do_produk".
 *
 * @property int $do_produk
 * @property int $do
 * @property int $stok_jenis
 * @property int $produk
 * @property int $do_jml
 * @property float $do_harga
 * @property float $harga_jual
 * @property int $do_produk_status
 * @property int $jml_now
 * @property string $do_produk_date
 * @property string|null $do_produk_date_stok
 * @property string $timestamp
 * @property int $do_produk_origin
 * @property int $inventori
 * @property int $rakitan
 * @property int $retur
 * @property int $size
 * @property int $merek
 * @property string|null $kategori_nama
 * @property string|null $merek_nama
 * @property string $nama_foto
 * @property string $type
 * @property string $url
 * @property string|null $batch
 *
 * @property Dop $do0
 * @property Inventori $inventori0
 * @property PenjualanProduk[] $penjualanProduks
 * @property Produk $produk0
 * @property Rakitan $rakitan0
 * @property Retur $retur0
 * @property StokJenis $stokJenis
 */
class DoProdukT extends \yii\db\ActiveRecord
{
    public $kategori_nama;
    public $merek_nama;
    public $merek;
    public $batch;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'do_produk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['do', 'produk', 'do_harga', 'do_produk_date'], 'required'],
            [['do', 'stok_jenis', 'produk', 'do_jml', 'do_produk_status', 'jml_now', 'do_produk_origin', 'inventori', 'rakitan', 'retur', 'size'], 'integer'],
            [['do_harga', 'harga_jual'], 'number'],
            [['kategori_nama', 'merek_nama', 'nama_foto', 'type', 'url'], 'string'],
            [['do_produk_date', 'do_produk_date_stok', 'timestamp'], 'safe'],
            [['inventori'], 'exist', 'skipOnError' => true, 'targetClass' => Inventori::className(), 'targetAttribute' => ['inventori' => 'inventori']],
            [['rakitan'], 'exist', 'skipOnError' => true, 'targetClass' => Rakitan::className(), 'targetAttribute' => ['rakitan' => 'rakitan']],
            [['retur'], 'exist', 'skipOnError' => true, 'targetClass' => Retur::className(), 'targetAttribute' => ['retur' => 'retur']],
            [['do'], 'exist', 'skipOnError' => true, 'targetClass' => Dop::className(), 'targetAttribute' => ['do' => 'do']],
            [['produk'], 'exist', 'skipOnError' => true, 'targetClass' => Produk::className(), 'targetAttribute' => ['produk' => 'produk']],
            [['stok_jenis'], 'exist', 'skipOnError' => true, 'targetClass' => StokJenis::className(), 'targetAttribute' => ['stok_jenis' => 'stok_jenis']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'do_produk' => 'Do Produk',
            'do' => 'Do',
            'stok_jenis' => 'Stok Jenis',
            'produk' => 'Produk',
            'merek' => 'Merek',
            'do_jml' => 'Do Jml',
            'do_harga' => 'Do Harga',
            'harga_jual' => 'Harga Jual',
            'do_produk_status' => 'Do Produk Status',
            'jml_now' => 'Jml Now',
            'do_produk_date' => 'Do Produk Date',
            'do_produk_date_stok' => 'Do Produk Date Stok',
            'timestamp' => 'Timestamp',
            'do_produk_origin' => 'Do Produk Origin',
            'inventori' => 'Inventori',
            'rakitan' => 'Rakitan',
            'retur' => 'Retur',
            'kategori_nama' => 'Kategori',
            'merek_nama' => 'Merek',
            'nama_foto' => 'Nama File',
            'type' => 'Type',
            'size' => 'Size',
            'url' => 'Url',
            'batch' => 'Batch'
        ];
    }

    /**
     * Gets query for [[Do0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDo0()
    {
        return $this->hasOne(Dop::className(), ['do' => 'do']);
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
     * Gets query for [[PenjualanProduks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualanProduks()
    {
        return $this->hasMany(PenjualanProduk::className(), ['do_produk' => 'do_produk']);
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
     * Gets query for [[Rakitan0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRakitan0()
    {
        return $this->hasOne(Rakitan::className(), ['rakitan' => 'rakitan']);
    }

    /**
     * Gets query for [[Retur0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRetur0()
    {
        return $this->hasOne(Retur::className(), ['retur' => 'retur']);
    }

    /**
     * Gets query for [[StokJenis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStokJenis()
    {
        return $this->hasOne(StokJenis::className(), ['stok_jenis' => 'stok_jenis']);
    }

}

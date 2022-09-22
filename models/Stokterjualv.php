<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stokterjualv".
 *
 * @property int $penjualan_produk
 * @property string|null $batch
 * @property int $penjualan
 * @property int $penjualan_jml
 * @property int $penjualan_harga
 * @property string|null $faktur
 * @property string|null $penjualan_tgl
 * @property string|null $produk_nama
 * @property string|null $kategori_nama
 * @property string|null $nama
 * @property string|null $stok_jenis_nama
 * @property string|null $kode
 * @property string|null $faktur_do
 * @property int|null $do
 * @property int|null $produk
 * @property int|null $do_produk
 * @property int|null $do_jml
 * @property int|null $jml_now
 * @property float|null $do_harga
 * @property float|null $harga_jual
 * @property int|null $do_produk_origin
 * @property int|null $rakitan
 * @property string|null $url
 */
class Stokterjualv extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stokterjualv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan_produk', 'penjualan', 'penjualan_jml', 'penjualan_harga', 'do', 'produk', 'do_produk', 'do_jml', 'jml_now', 'do_produk_origin', 'rakitan'], 'integer'],
            [['penjualan', 'penjualan_jml', 'penjualan_harga'], 'required'],
            [['penjualan_tgl'], 'safe'],
            [['do_harga', 'harga_jual'], 'number'],
            [['batch'], 'string', 'max' => 511],
            [['faktur', 'produk_nama', 'kategori_nama', 'nama', 'stok_jenis_nama', 'kode', 'faktur_do', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'penjualan_produk' => 'Penjualan Produk',
            'batch' => 'Batch',
            'penjualan' => 'Penjualan',
            'penjualan_jml' => 'Penjualan Jml',
            'penjualan_harga' => 'Penjualan Harga',
            'faktur' => 'Faktur',
            'penjualan_tgl' => 'Penjualan Tgl',
            'produk_nama' => 'Produk Nama',
            'kategori_nama' => 'Kategori Nama',
            'nama' => 'Nama',
            'stok_jenis_nama' => 'Stok Jenis Nama',
            'kode' => 'Kode',
            'faktur_do' => 'Faktur Do',
            'do' => 'Do',
            'produk' => 'Produk',
            'do_produk' => 'Do Produk',
            'do_jml' => 'Do Jml',
            'jml_now' => 'Jml Now',
            'do_harga' => 'Do Harga',
            'harga_jual' => 'Harga Jual',
            'do_produk_origin' => 'Do Produk Origin',
            'rakitan' => 'Rakitan',
            'url' => 'Url',
        ];
    }
}

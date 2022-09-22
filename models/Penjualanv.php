<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penjualanv".
 *
 * @property int $penjualan
 * @property string $penjualan_tgl
 * @property string|null $konsumen_nama
 * @property string $faktur
 * @property string|null $surat_jalan
 * @property string $penjualan_status
 * @property int|null $penjualan_ongkir
 * @property string|null $sales
 * @property int|null $penjualan_diskon
 * @property float|null $total
 * @property float|null $ppn
 * @property float|null $total_plus_ppn
 * @property float|null $total_bayar
 */
class Penjualanv extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penjualanv';
    }
    
    /**
     * @inheritdoc$primaryKey
     */
    public static function primaryKey()
    {
        return ["penjualan"];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan', 'penjualan_ongkir', 'penjualan_diskon'], 'integer'],
            [['penjualan_tgl', 'faktur', 'penjualan_status'], 'required'],
            [['penjualan_tgl'], 'safe'],
            [['total', 'ppn', 'total_plus_ppn', 'total_bayar'], 'number'],
            [['konsumen_nama', 'faktur', 'surat_jalan'], 'string', 'max' => 255],
            [['penjualan_status'], 'string', 'max' => 20],
            [['sales'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'penjualan' => 'Penjualan',
            'penjualan_tgl' => 'Penjualan Tgl',
            'konsumen_nama' => 'Konsumen Nama',
            'faktur' => 'Faktur',
            'surat_jalan' => 'Surat Jalan',
            'penjualan_status' => 'Penjualan Status',
            'penjualan_ongkir' => 'Penjualan Ongkir',
            'sales' => 'Sales',
            'penjualan_diskon' => 'Penjualan Diskon',
            'total' => 'Total',
            'ppn' => 'Ppn',
            'total_plus_ppn' => 'Total Plus Ppn',
            'total_bayar' => 'Total Bayar',
        ];
    }
}

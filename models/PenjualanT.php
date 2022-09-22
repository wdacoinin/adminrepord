<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penjualan".
 *
 * @property int $penjualan
 * @property string $penjualan_tgl
 * @property string|null $penjualan_tempo
 * @property int $konsumen
 * @property string $faktur
 * @property string|null $surat_jalan
 * @property string|null $keterangan
 * @property int $penjualan_ongkir
 * @property int $fee
 * @property string|null $fee_date
 * @property string $konsumen_nama
 * @property string $penjualan_type
 * @property string|null $konsumen_telp
 * @property int $sales
 * @property int $penjualan_diskon
 * @property int|null $user
 * @property string $penjualan_status
 * @property int|null $akun
 * @property int|null $total_bahan
 *
 * @property Konsumen $konsumen0
 * @property PenjualanProduk[] $penjualanProduks
 * @property User $user0
 */
class PenjualanT extends \yii\db\ActiveRecord
{
    public $konsumen_nama;
    public $konsumen_telp;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penjualan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan_tgl', 'faktur', 'sales', 'penjualan_status'], 'required'],
            [['penjualan_tgl', 'penjualan_tempo', 'fee_date'], 'safe'],
            [['konsumen', 'penjualan_ongkir', 'fee', 'sales', 'penjualan_diskon', 'user', 'akun', 'total_bahan'], 'integer'],
            [['keterangan'], 'string'],
            [['faktur', 'surat_jalan', 'konsumen_nama'], 'string', 'max' => 255],
            [['penjualan_status', 'konsumen_telp'], 'string', 'max' => 20],
            [['penjualan_type'], 'string', 'max' => 50],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
            [['konsumen'], 'exist', 'skipOnError' => true, 'targetClass' => Konsumen::className(), 'targetAttribute' => ['konsumen' => 'konsumen']],
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
            'penjualan_tempo' => 'Penjualan Tempo',
            'konsumen' => 'Konsumen',
            'faktur' => 'Faktur',
            'surat_jalan' => 'Surat Jalan',
            'keterangan' => 'Keterangan',
            'penjualan_ongkir' => 'Penjualan Ongkir',
            'fee' => 'Fee',
            'fee_date' => 'Fee Date',
            'sales' => 'Sales',
            'penjualan_diskon' => 'Penjualan Diskon',
            'user' => 'User',
            'penjualan_status' => 'Penjualan Status',
            'akun' => 'Akun',
            'total_bahan' => 'Total Bahan',
            'konsumen_nama' => 'Nama Konsumen',
            'konsumen_telp' => 'Telp. Konsumen',
            'penjualan_type' => 'Tipe'
        ];
    }

    /**
     * Gets query for [[Konsumen0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKonsumen0()
    {
        return $this->hasOne(Konsumen::className(), ['konsumen' => 'konsumen']);
    }

    /**
     * Gets query for [[PenjualanProduks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualanProduks()
    {
        return $this->hasMany(PenjualanProduk::className(), ['penjualan' => 'penjualan']);
    }

    /**
     * Gets query for [[User0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }
}

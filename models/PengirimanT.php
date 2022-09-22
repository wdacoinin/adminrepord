<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pengiriman".
 *
 * @property int $pengiriman
 * @property string $surat_jalan
 * @property int|null $user
 * @property int|null $penjualan
 * @property string|null $nama_penerima
 * @property string|null $cp
 * @property string $Alamat
 * @property string|null $datetime
 * @property string|null $nama_foto
 * @property string|null $type
 * @property int|null $size
 * @property string|null $url
 * @property string|null $lat
 * @property string|null $lon
 * @property string|null $keterangan
 *
 * @property User $user0
 */
class PengirimanT extends \yii\db\ActiveRecord
{
    public $penjualan;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pengiriman';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['surat_jalan', 'Alamat'], 'required'],
            [['user', 'size', 'penjualan'], 'integer'],
            [['Alamat', 'keterangan'], 'string'],
            [['datetime'], 'safe'],
            [['surat_jalan', 'nama_penerima', 'cp', 'nama_foto', 'type', 'url', 'lat', 'lon'], 'string', 'max' => 255],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pengiriman' => 'Pengiriman',
            'surat_jalan' => 'Surat Jalan',
            'user' => 'User',
            'nama_penerima' => 'Penerima / Pemberi Barang',
            'cp' => 'Cp',
            'Alamat' => 'Alamat',
            'datetime' => 'Datetime',
            'nama_foto' => 'Nama Foto',
            'type' => 'Type',
            'size' => 'Size',
            'url' => 'Url',
            'lat' => 'Lat',
            'lon' => 'Lon',
            'keterangan' => 'Keterangan',
            'penjualan' => 'No.penjualan'
        ];
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

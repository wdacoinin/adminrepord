<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wo".
 *
 * @property int $wo
 * @property string $status
 * @property int|null $penjualan
 * @property string|null $nama_foto
 * @property string|null $type
 * @property string|null $url
 * @property int|null $size
 * @property int|null $id_user
 * @property int|null $konsumen
 * @property string $konsumen_nama
 * @property string|null $konsumen_telp
 *
 * @property DoProduk[] $doProduks
 * @property Konsumen $konsumen0
 * @property User $user
 * @property WoProduk[] $woProduks
 */
class WoT extends \yii\db\ActiveRecord
{
    public $konsumen_nama;
    public $konsumen_telp;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan', 'size', 'id_user', 'konsumen'], 'integer'],
            [['status', 'nama_foto', 'type', 'url', 'konsumen_nama'], 'string', 'max' => 255],
            [['konsumen_telp'], 'string', 'max' => 20],
            //[['penjualan'], 'exist', 'skipOnError' => true, 'targetClass' => Penjualan::className(), 'targetAttribute' => ['penjualan' => 'penjualan']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['konsumen'], 'exist', 'skipOnError' => true, 'targetClass' => Konsumen::className(), 'targetAttribute' => ['konsumen' => 'konsumen']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'wo' => 'Wo',
            'status' => 'Status',
            'penjualan' => 'Penjualan',
            'nama_foto' => 'Nama Foto',
            'type' => 'Type',
            'url' => 'Url',
            'size' => 'Size',
            'id_user' => 'Id User',
            'konsumen' => 'Konsumen',
            'konsumen_nama' => 'Nama Konsumen',
            'konsumen_telp' => 'Telp. Konsumen'
        ];
    }

    /**
     * Gets query for [[DoProduks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDoProduks()
    {
        return $this->hasMany(DoProduk::className(), ['wo' => 'wo']);
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
     * Gets query for [[Penjualan0]].
     *
     * @return \yii\db\ActiveQuery
     */
    /* public function getPenjualan0()
    {
        return $this->hasOne(Penjualan::className(), ['penjualan' => 'penjualan']);
    } */

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * Gets query for [[WoProduks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWoProduks()
    {
        return $this->hasMany(WoProduk::className(), ['wo' => 'wo']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string|null $authKey
 * @property string|null $accessToken
 * @property string $nama
 * @property string|null $phone
 * @property string|null $nama_foto
 * @property string|null $type
 * @property string|null $url
 * @property int $size
 * @property int $divisi
 * @property float $gaji
 * @property string $create_date
 *
 * @property AkunSaldo[] $akunSaldos
 * @property Divisi $divisi0
 * @property DopT[] $dos
 * @property PenjualanProdukTt[] $penjualanProdukTts
 * @property PenjualanProduk[] $penjualanProduks
 * @property Penjualan[] $penjualans
 * @property Penjualan[] $penjualans0
 * @property Rakitan[] $rakitans
 * @property Rma[] $rmas
 * @property WoProduk[] $woProduks
 * @property Wo[] $wos
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'nama', 'divisi'], 'required'],
            [['divisi', 'size'], 'integer'],
            [['gaji'], 'number'],
            [['create_date'], 'safe'],
            [['username', 'password', 'authKey', 'accessToken', 'nama_foto', 'type', 'url'], 'string', 'max' => 255],
            [['nama'], 'string', 'max' => 150],
            [['phone'], 'string', 'max' => 14],
            [['divisi'], 'exist', 'skipOnError' => true, 'targetClass' => Divisi::className(), 'targetAttribute' => ['divisi' => 'divisi']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'nama' => 'Nama',
            'phone' => 'Phone',
            'divisi' => 'Divisi',
            'gaji' => 'Gaji',
            'create_date' => 'Create Date',
            'nama_foto' => 'Foto',
            'type' => 'File Type',
            'url' => 'Url',
            'size' => 'Size',
        ];
    }

    /**
     * Gets query for [[AkunSaldos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAkunSaldos()
    {
        return $this->hasMany(AkunSaldo::className(), ['user' => 'id']);
    }

    /**
     * Gets query for [[Divisi0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDivisi0()
    {
        return $this->hasOne(Divisi::className(), ['divisi' => 'divisi']);
    }

    /**
     * Gets query for [[Dos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDos()
    {
        return $this->hasMany(DopT::className(), ['us' => 'id']);
    }

    /**
     * Gets query for [[PenjualanProdukTts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualanProdukTts()
    {
        return $this->hasMany(PenjualanProdukTt::className(), ['user_input' => 'id']);
    }

    /**
     * Gets query for [[PenjualanProduks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualanProduks()
    {
        return $this->hasMany(PenjualanProduk::className(), ['user_input' => 'id']);
    }

    /**
     * Gets query for [[Penjualans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualans()
    {
        return $this->hasMany(Penjualan::className(), ['sales' => 'id']);
    }

    /**
     * Gets query for [[Penjualans0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualans0()
    {
        return $this->hasMany(Penjualan::className(), ['user' => 'id']);
    }

    /**
     * Gets query for [[Rakitans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRakitans()
    {
        return $this->hasMany(Rakitan::className(), ['id_user' => 'id']);
    }

    /**
     * Gets query for [[Rmas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRmas()
    {
        return $this->hasMany(Rma::className(), ['id_user' => 'id']);
    }

    /**
     * Gets query for [[WoProduks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWoProduks()
    {
        return $this->hasMany(WoProduk::className(), ['user_input' => 'id']);
    }

    /**
     * Gets query for [[Wos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWos()
    {
        return $this->hasMany(Wo::className(), ['id_user' => 'id']);
    }
}

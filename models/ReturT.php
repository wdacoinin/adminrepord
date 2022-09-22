<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "retur".
 *
 * @property int $retur
 * @property int $do
 * @property string $noretur
 * @property string $date
 * @property int $user
 * @property int $retur_status
 * @property int $do_produk
 * @property int $qty_retur
 
 * @property string|null $keterangan
 * @property string|null $nama_foto
 * @property string|null $type
 * @property int|null $size
 * @property string|null $url
 *
 * @property DopT $do0
 * @property DoProduk[] $doProduks
 * @property User $user0
 */
class ReturT extends \yii\db\ActiveRecord
{
    public $do_produk;
    public $qty_retur;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'retur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['do', 'noretur', 'date', 'user'], 'required'],
            [['do', 'user', 'retur_status', 'size', 'do_produk', 'qty_retur'], 'integer'],
            [['date'], 'safe'],
            [['keterangan'], 'string'],
            [['noretur', 'nama_foto', 'type', 'url'], 'string', 'max' => 255],
            [['do'], 'exist', 'skipOnError' => true, 'targetClass' => DopT::className(), 'targetAttribute' => ['do' => 'do']],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'retur' => 'Retur',
            'do' => 'Do',
            'noretur' => 'Noretur',
            'date' => 'Date',
            'user' => 'User',
            'retur_status' => 'Retur Status',
            'keterangan' => 'Keterangan',
            'nama_foto' => 'Nama Foto',
            'type' => 'Type',
            'size' => 'Size',
            'url' => 'Url',
            'do_produk' => 'Produk',
            'qty_retur' => 'Jml Retur',
        ];
    }

    /**
     * Gets query for [[Do0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDo0()
    {
        return $this->hasOne(DopT::className(), ['do' => 'do']);
    }

    /**
     * Gets query for [[DoProduks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDoProduks()
    {
        return $this->hasMany(DoProduk::className(), ['retur' => 'retur']);
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

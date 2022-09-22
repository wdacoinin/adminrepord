<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "akun_saldo".
 *
 * @property int $akun_saldo
 * @property int $aktiva
 * @property int $beban
 * @property int $beban_jenis
 * @property int $akun
 * @property int|null $noref
 * @property string|null $notrans
 * @property string $ket
 * @property float $jml
 * @property string $datetime
 * @property int $user
 * @property string|null $nama_foto
 * @property string|null $type
 * @property int $size
 * @property string|null $url
 *
 * @property Aktiva $aktiva0
 * @property Akun $akun0
 * @property Beban $beban0
 * @property User $user0
 */
class AkunSaldoT extends \yii\db\ActiveRecord
{
    public $beban_jenis;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akun_saldo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aktiva', 'akun', 'ket', 'jml', 'datetime', 'user'], 'required'],
            [['aktiva', 'beban', 'beban_jenis', 'akun', 'noref', 'user', 'size'], 'integer'],
            [['ket'], 'string'],
            [['jml'], 'number'],
            [['datetime'], 'safe'],
            [['notrans', 'type'], 'string', 'max' => 50],
            [['nama_foto', 'url'], 'string', 'max' => 255],
            [['akun'], 'exist', 'skipOnError' => true, 'targetClass' => Akun::className(), 'targetAttribute' => ['akun' => 'akun']],
            [['aktiva'], 'exist', 'skipOnError' => true, 'targetClass' => Aktiva::className(), 'targetAttribute' => ['aktiva' => 'aktiva']],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
            [['beban'], 'exist', 'skipOnError' => true, 'targetClass' => Beban::className(), 'targetAttribute' => ['beban' => 'beban']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'akun_saldo' => 'Akun Saldo',
            'aktiva' => 'Aktiva',
            'beban' => 'Beban',
            'beban_jenis' => 'Jenis Beban',
            'akun' => 'Akun',
            'noref' => 'Noref',
            'notrans' => 'Notrans',
            'ket' => 'Ket',
            'jml' => 'Jml',
            'datetime' => 'Datetime',
            'user' => 'User',
            'nama_foto' => 'Nama Foto',
            'type' => 'Type',
            'size' => 'Size',
            'url' => 'Url',
        ];
    }

    /**
     * Gets query for [[Aktiva0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAktiva0()
    {
        return $this->hasOne(Aktiva::className(), ['aktiva' => 'aktiva']);
    }

    /**
     * Gets query for [[Akun0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAkun0()
    {
        return $this->hasOne(Akun::className(), ['akun' => 'akun']);
    }

    /**
     * Gets query for [[Beban0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBeban0()
    {
        return $this->hasOne(Beban::className(), ['beban' => 'beban']);
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

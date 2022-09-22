<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "akun".
 *
 * @property int $akun
 * @property string|null $akun_nama
 * @property string $an
 * @property string $akun_ref
 * @property int $akun_owner
 * @property string $akun_type
 *
 * @property AkunSaldo[] $akunSaldos
 */
class AkunT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akun';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['akun_nama', 'an', 'akun_ref'], 'required'],
            [['akun_owner'], 'integer'],
            [['akun_nama', 'an', 'akun_ref', 'akun_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'akun' => 'Akun',
            'akun_nama' => 'Akun Nama',
            'an' => 'An',
            'akun_ref' => 'Akun Ref',
            'akun_owner' => 'Akun Owner',
            'akun_type' => 'Akun Type',
        ];
    }

    /**
     * Gets query for [[AkunSaldos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAkunSaldos()
    {
        return $this->hasMany(AkunSaldo::className(), ['akun' => 'akun']);
    }
}

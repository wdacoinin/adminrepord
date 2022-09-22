<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "merek".
 *
 * @property int $merek
 * @property string $nama
 *
 * @property Produk[] $produks
 */
class MerekT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'merek';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'merek' => 'Merek',
            'nama' => 'Nama',
        ];
    }

    /**
     * Gets query for [[Produks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduks()
    {
        return $this->hasMany(Produk::className(), ['merek' => 'merek']);
    }
}

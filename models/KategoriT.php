<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kategori".
 *
 * @property int $kategori
 * @property string $kategori_nama
 * @property int|null $kategori_urutan
 *
 * @property Produk[] $produks
 */
class KategoriT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kategori';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kategori_nama'], 'required'],
            [['kategori_urutan'], 'integer'],
            [['kategori_nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kategori' => 'Kategori',
            'kategori_nama' => 'Kategori Nama',
            'kategori_urutan' => 'Kategori Urutan',
        ];
    }

    /**
     * Gets query for [[Produks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduks()
    {
        return $this->hasMany(Produk::className(), ['kategori' => 'kategori']);
    }
}

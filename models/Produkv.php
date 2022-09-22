<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produkv".
 *
 * @property int $produk
 * @property string $nama
 * @property int $kategori
 * @property int $merek
 * @property string $status
 * @property string|null $merek_nama
 * @property string|null $kategori_nama
 * @property float|null $jml_now
 * @property float|null $jml_retur
 */
class Produkv extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produkv';
    }
    
    /**
     * @inheritdoc$primaryKey
     */
    public static function primaryKey()
    {
        return ["produk"];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produk', 'kategori', 'merek'], 'integer'],
            [['nama', 'kategori', 'merek', 'status'], 'required'],
            [['jml_now', 'jml_retur'], 'number'],
            [['nama', 'merek_nama', 'kategori_nama'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'produk' => 'Produk',
            'nama' => 'Nama',
            'kategori' => 'Kategori',
            'merek' => 'Merek',
            'status' => 'Status',
            'merek_nama' => 'Merek Nama',
            'kategori_nama' => 'Kategori Nama',
            'jml_now' => 'Jml Now',
            'jml_retur' => 'Jml Retur',
        ];
    }
}

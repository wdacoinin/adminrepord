<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stok_jenis".
 *
 * @property int $stok_jenis
 * @property string $stok_jenis_nama
 * @property int $stok_jenis_status
 */
class StokJenisT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stok_jenis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['stok_jenis_nama', 'stok_jenis_status'], 'required'],
            [['stok_jenis_status'], 'integer'],
            [['stok_jenis_nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'stok_jenis' => 'Stok Jenis',
            'stok_jenis_nama' => 'Stok Jenis Nama',
            'stok_jenis_status' => 'Stok Jenis Status',
        ];
    }
}

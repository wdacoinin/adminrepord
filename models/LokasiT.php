<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lokasi".
 *
 * @property int $lokasi
 * @property string $nama
 * @property string|null $detail
 *
 * @property Inventori[] $inventoris
 */
class LokasiT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lokasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama', 'detail'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lokasi' => 'Lokasi',
            'nama' => 'Nama',
            'detail' => 'Detail',
        ];
    }

    /**
     * Gets query for [[Inventoris]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInventoris()
    {
        return $this->hasMany(Inventori::className(), ['lokasi' => 'lokasi']);
    }
}

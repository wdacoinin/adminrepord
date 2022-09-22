<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "doc_penj".
 *
 * @property int $id_img
 * @property int $penjualan
 * @property string $doc
 * @property string $nama_foto
 * @property string $type
 * @property int $size
 * @property string $url
 *
 * @property Penjualan $penjualan0
 */
class DocPenjT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doc_penj';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan', 'doc', 'nama_foto', 'type', 'size', 'url'], 'required'],
            [['penjualan', 'size'], 'integer'],
            [['doc', 'type'], 'string', 'max' => 50],
            [['nama_foto', 'url'], 'string', 'max' => 255],
            [['penjualan'], 'exist', 'skipOnError' => true, 'targetClass' => Penjualan::className(), 'targetAttribute' => ['penjualan' => 'penjualan']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_img' => 'Id Img',
            'penjualan' => 'Penjualan',
            'doc' => 'Doc',
            'nama_foto' => 'Nama Foto',
            'type' => 'Type',
            'size' => 'Size',
            'url' => 'Url',
        ];
    }

    /**
     * Gets query for [[Penjualan0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualan0()
    {
        return $this->hasOne(Penjualan::className(), ['penjualan' => 'penjualan']);
    }
}

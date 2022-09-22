<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "doc_pemb".
 *
 * @property int $id_img
 * @property int $do
 * @property string $doc
 * @property string $nama_foto
 * @property string $type
 * @property int $size
 * @property string $url
 *
 * @property Dopembelian $do0
 */
class DocPembT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doc_pemb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['do', 'nama_foto', 'type', 'size', 'url'], 'required'],
            [['do', 'size'], 'integer'],
            [['doc', 'type'], 'string', 'max' => 50],
            [['nama_foto', 'url'], 'string', 'max' => 255],
            [['do'], 'exist', 'skipOnError' => true, 'targetClass' => Dopembelian::className(), 'targetAttribute' => ['do' => 'do']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_img' => 'Id Img',
            'do' => 'Do',
            'doc' => 'Doc',
            'nama_foto' => 'Nama Foto',
            'type' => 'Type',
            'size' => 'Size',
            'url' => 'Url',
        ];
    }

    /**
     * Gets query for [[Do0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDo0()
    {
        return $this->hasOne(Dopembelian::className(), ['do' => 'do']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "absen".
 *
 * @property int $absen
 * @property int $id
 * @property string $datetime
 * @property string $nama_foto
 * @property string $type
 * @property int $size
 * @property string $url
 * @property string $lat
 * @property string $lon
 *
 * @property User $id0
 */
class AbsenT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'absen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nama_foto', 'type', 'size', 'url', 'lat', 'lon'], 'required'],
            [['id', 'size'], 'integer'],
            [['datetime'], 'safe'],
            [['nama_foto', 'type', 'url', 'lat', 'lon'], 'string', 'max' => 255],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'absen' => 'Absen',
            'id' => 'ID',
            'datetime' => 'Datetime',
            'nama_foto' => 'Nama Foto',
            'type' => 'Type',
            'size' => 'Size',
            'url' => 'Url',
            'lat' => 'Lat',
            'lon' => 'Lon',
        ];
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }
}

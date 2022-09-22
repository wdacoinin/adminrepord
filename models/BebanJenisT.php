<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "beban_jenis".
 *
 * @property int $beban_jenis
 * @property string $beban_jenis_nama
 * @property int $status
 *
 * @property Beban[] $bebans
 */
class BebanJenisT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'beban_jenis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['beban_jenis_nama', 'status'], 'required'],
            [['status'], 'integer'],
            [['beban_jenis_nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'beban_jenis' => 'Beban Jenis',
            'beban_jenis_nama' => 'Beban Jenis Nama',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Bebans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBebans()
    {
        return $this->hasMany(Beban::className(), ['beban_jenis' => 'beban_jenis']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "beban".
 *
 * @property int $beban
 * @property int $beban_jenis
 * @property string $nama
 *
 * @property BebanJenis $bebanJenis
 */
class BebanT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'beban';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['beban_jenis', 'nama'], 'required'],
            [['beban_jenis'], 'integer'],
            [['nama'], 'string', 'max' => 255],
            [['beban_jenis'], 'exist', 'skipOnError' => true, 'targetClass' => BebanJenis::className(), 'targetAttribute' => ['beban_jenis' => 'beban_jenis']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'beban' => 'Beban',
            'beban_jenis' => 'Beban Jenis',
            'nama' => 'Nama',
        ];
    }

    /**
     * Gets query for [[BebanJenis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBebanJenis()
    {
        return $this->hasOne(BebanJenis::className(), ['beban_jenis' => 'beban_jenis']);
    }
}

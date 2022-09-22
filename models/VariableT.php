<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "variable".
 *
 * @property int $variable
 * @property string $nama
 * @property int|null $divisi
 * @property int $val
 * @property string|null $detail
 * @property string|null $status
 * 
 * @property Divisi $divisi0
 */
class VariableT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'variable';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'val'], 'required'],
            [['divisi', 'val'], 'integer'],
            [['detail'], 'string'],
            [['nama'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 20],
            [['divisi'], 'exist', 'skipOnError' => true, 'targetClass' => Divisi::className(), 'targetAttribute' => ['divisi' => 'divisi']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'variable' => 'Variable',
            'nama' => 'Nama',
            'divisi' => 'Divisi',
            'val' => 'Val',
            'detail' => 'Detail',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Divisi0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDivisi0()
    {
        return $this->hasOne(Divisi::className(), ['divisi' => 'divisi']);
    }
}

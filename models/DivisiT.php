<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "divisi".
 *
 * @property int $divisi
 * @property string $nama
 * @property string $des
 * @property int $status
 */
class DivisiT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'divisi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'des'], 'required'],
            [['des'], 'string'],
            [['status'], 'integer'],
            [['nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'divisi' => 'Divisi',
            'nama' => 'Nama',
            'des' => 'Des',
            'status' => 'Status',
        ];
    }
}

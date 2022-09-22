<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "do".
 *
 * @property int $do
 * @property string $do_tgl
 * @property int $supplier
 * @property string $do_status
 * @property int $us
 * @property string|null $faktur
 * @property string|null $do_tempo
 * @property string|null $no_sj
 * @property string|null $keterangan
 * @property float|null $do_diskon
 * @property int $ppn
 *
 * @property DoProduk[] $doProduks
 * @property Supplier $supplier0
 * @property User $us0
 */
class DopT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'do';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['do_tgl', 'supplier', 'do_status', 'us'], 'required'],
            [['do_tgl', 'do_tempo'], 'safe'],
            [['supplier', 'us', 'ppn'], 'integer'],
            [['keterangan'], 'string'],
            [['do_diskon'], 'number'],
            [['do_status'], 'string', 'max' => 20],
            [['faktur', 'no_sj'], 'string', 'max' => 255],
            [['supplier'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['supplier' => 'supplier']],
            [['us'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['us' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'do' => 'Do',
            'do_tgl' => 'Do Tgl',
            'supplier' => 'Supplier',
            'do_status' => 'Do Status',
            'us' => 'Us',
            'faktur' => 'Faktur',
            'do_tempo' => 'Do Tempo',
            'no_sj' => 'No Sj',
            'keterangan' => 'Keterangan',
            'do_diskon' => 'Do Diskon',
            'ppn' => 'Ppn',
        ];
    }

    /**
     * Gets query for [[DoProduks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDoProduks()
    {
        return $this->hasMany(DoProduk::className(), ['do' => 'do']);
    }

    /**
     * Gets query for [[Supplier0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier0()
    {
        return $this->hasOne(Supplier::className(), ['supplier' => 'supplier']);
    }

    /**
     * Gets query for [[Us0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUs0()
    {
        return $this->hasOne(User::className(), ['id' => 'us']);
    }
}

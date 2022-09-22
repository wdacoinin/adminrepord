<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dopembelianv".
 *
 * @property int $do
 * @property string $do_tgl
 * @property string|null $supplier_nama
 * @property string|null $faktur
 * @property string|null $do_tempo
 * @property string|null $no_sj
 * @property string $do_status
 * @property string|null $nama
 * @property float|null $do_diskon
 * @property float|null $total
 * @property float|null $ppn
 * @property float|null $total_plus_ppn
 * @property float|null $total_bayar
 */
class Dopembelianv extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dopembelianv';
    }
    
    /**
     * @inheritdoc$primaryKey
     */
    public static function primaryKey()
    {
        return ["do"];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['do'], 'integer'],
            [['do_tgl', 'do_status'], 'required'],
            [['do_tgl', 'do_tempo'], 'safe'],
            [['do_diskon', 'total', 'ppn', 'total_plus_ppn', 'total_bayar'], 'number'],
            [['supplier_nama', 'faktur', 'no_sj'], 'string', 'max' => 255],
            [['do_status'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 150],
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
            'supplier_nama' => 'Supplier Nama',
            'faktur' => 'Faktur',
            'do_tempo' => 'Do Tempo',
            'no_sj' => 'No Sj',
            'do_status' => 'Status',
            'nama' => 'Nama',
            'do_diskon' => 'Do Diskon',
            'total' => 'Total',
            'ppn' => 'Ppn',
            'total_plus_ppn' => 'Total Plus Ppn',
            'total_bayar' => 'Total Bayar'
        ];
    }
}

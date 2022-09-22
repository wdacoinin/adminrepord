<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property int $supplier
 * @property string $supplier_nama
 * @property string $supplier_detail
 */
class SupplierT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['supplier_nama', 'supplier_detail'], 'required'],
            [['supplier_nama', 'supplier_detail'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'supplier' => 'Supplier',
            'supplier_nama' => 'Supplier Nama',
            'supplier_detail' => 'Supplier Detail',
        ];
    }
}

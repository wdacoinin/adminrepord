<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rma".
 *
 * @property int $rma
 * @property string $rma_status
 * @property string|null $rma_nota
 * @property string|null $nama_foto
 * @property string|null $type
 * @property string|null $url
 * @property int|null $size
 * @property int $id_user
 * @property int $konsumen
 * @property string $rma_date
 *
 * @property Konsumen $konsumen0
 * @property RmaItem[] $rmaItems
 * @property User $user
 */
class RmaT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rma';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rma_status', 'id_user', 'konsumen', 'rma_date'], 'required'],
            [['size', 'id_user', 'konsumen'], 'integer'],
            [['rma_date'], 'safe'],
            [['rma_status'], 'string', 'max' => 50],
            [['rma_nota', 'nama_foto', 'type', 'url'], 'string', 'max' => 255],
            [['konsumen'], 'exist', 'skipOnError' => true, 'targetClass' => Konsumen::className(), 'targetAttribute' => ['konsumen' => 'konsumen']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rma' => 'Rma',
            'rma_status' => 'Rma Status',
            'rma_nota' => 'Rma Nota',
            'nama_foto' => 'Nama Foto',
            'type' => 'Type',
            'url' => 'Url',
            'size' => 'Size',
            'id_user' => 'Id User',
            'konsumen' => 'Konsumen',
            'rma_date' => 'Rma Date',
        ];
    }

    /**
     * Gets query for [[Konsumen0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKonsumen0()
    {
        return $this->hasOne(Konsumen::className(), ['konsumen' => 'konsumen']);
    }

    /**
     * Gets query for [[RmaItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRmaItems()
    {
        return $this->hasMany(RmaItem::className(), ['rma' => 'rma']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}

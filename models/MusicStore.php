<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "music_store".
 *
 * @property int $id
 * @property string $storeNo
 * @property string $storeName
 * @property string $customerName
 * @property string $address
 * @property string $createTime
 * @property string $updateTime
 */
class MusicStore extends BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'music_store';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['storeNo', 'storeName', 'customerName'], 'required'],
            [['createTime', 'updateTime'], 'safe'],
            [['storeNo', 'customerName'], 'string', 'max' => 20],
            [['storeName'], 'string', 'max' => 32],
            [['address'], 'string', 'max' => 64],
            [['storeNo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'storeNo' => '门店编号',
            'storeName' => '门店名称',
            'customerName' => '客户名称',
            'address' => '地址',
            'createTime' => '创建时间',
            'updateTime' => '修改时间',
        ];
    }
}

<?php

namespace app\models;

use app\utils\Utils;
use Yii;


/**
 * This is the model class for table "music_device".
 *
 * @property int $id
 * @property string $deviceNo
 * @property string $deviceName
 * @property string $mac
 * @property string $storeNo
 * @property int $onlineStatus
 * @property int $registerStatus
 * @property string $storageCard
 * @property string $appVersion
 * @property string $deviceSound
 * @property string $lastMsgTime
 * @property string $createTime
 * @property string $updateTime
 */
class MusicDevice extends BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'music_device';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deviceNo', 'deviceName', 'storeNo'], 'required'],
            [['onlineStatus', 'registerStatus'], 'integer'],
            [['lastMsgTime', 'createTime', 'updateTime'], 'safe'],
            [['deviceNo', 'storageCard'], 'string', 'max' => 10],
            [['deviceName', 'mac'], 'string', 'max' => 32],
            [['storeNo', 'deviceSound'], 'string', 'max' => 20],
            [['appVersion'], 'string', 'max' => 30],
            [['deviceNo'], 'unique'],
            [['mac'], 'unique'],
            [['storeNo'], 'exist', 'skipOnError' => true, 'targetClass' => MusicStore::className(), 'targetAttribute' => ['storeNo' => 'storeNo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'deviceNo' => '设备编号',
            'deviceName' => '设备名称',
            'mac' => 'Mac地址',
            'storeNo' => '门店编号',
            'onlineStatus' => '在线状态',
            'registerStatus' => '注册状态',
            'storageCard' => '存储空间',
            'appVersion' => 'App版本',
            'deviceSound' => '设备音量',
            'lastMsgTime' => '最后通讯时间',
            'createTime' => '创建时间',
            'updateTime' => '修改时间',
        ];
    }
    protected function doBeforeSave()
    {
        $this->onlineStatus=0;
        $this->registerStatus=0;
        $this->mac = Utils::getRegCode();
    }

}

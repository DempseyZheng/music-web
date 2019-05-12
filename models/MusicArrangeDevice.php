<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "music_arrange_device".
 *
 * @property int $id
 * @property string $storeNo
 * @property string $deviceNo
 * @property int $progress
 * @property int $pubStatus
 * @property int $arrangeStatus
 * @property string $arrangeNo
 * @property string $arrangeName
 * @property string $beginDate
 * @property string $endDate
 * @property string $beginTime
 * @property string $endTime
 * @property int $arrangeLevel
 * @property string $createTime
 * @property string $updateTime
 * @property MusicArrange $arrange
 */
class MusicArrangeDevice extends BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'music_arrange_device';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['storeNo', 'deviceNo', 'arrangeNo', 'arrangeName', 'beginTime', 'endTime', 'arrangeLevel'], 'required'],
            [['progress', 'pubStatus', 'arrangeStatus', 'arrangeLevel'], 'integer'],
            [['beginDate', 'endDate', 'createTime', 'updateTime'], 'safe'],
            [['storeNo', 'beginTime', 'endTime'], 'string', 'max' => 10],
            [['deviceNo', 'arrangeNo'], 'string', 'max' => 20],
            [['arrangeName'], 'string', 'max' => 64],
            [['deviceNo', 'arrangeNo'], 'unique', 'targetAttribute' => ['deviceNo', 'arrangeNo']],
//            [['arrangeNo'], 'exist', 'skipOnError' => true, 'targetClass' => MusicArrange::className(), 'targetAttribute' => ['arrangeNo' => 'arrangeNo']],
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
            'deviceNo' => '设备编号',
            'progress' => '发布进度',
            'pubStatus' => '发布状态',
            'arrangeStatus' => '播期状态',
            'arrangeNo' => '播期编号',
            'arrangeName' => '播期名称',
            'beginDate' => '开始日期',
            'endDate' => '结束日期',
            'beginTime' => '开始时间',
            'endTime' => '结束时间',
            'arrangeLevel' => '播期等级',
            'createTime' => '创建时间',
            'updateTime' => '修改时间',
        ];
    }

//    public function getArrange()
//    {
//        return $this->hasOne(MusicArrange::className(), ['arrangeNo' => 'arrangeNo']);
//    }
}

<?php

namespace app\models;

use app\utils\NoBuilder;
use app\utils\RedisHelper;
use app\utils\Utils;
use Yii;

/**
 * This is the model class for table "music_arrange".
 *
 * @property int $id
 * @property string $arrangeNo
 * @property string $arrangeName
 * @property string $customerName
 * @property string $beginDate
 * @property string $endDate
 * @property string $beginTime
 * @property string $endTime
 * @property int $arrangeLevel
 * @property string $createTime
 * @property string $updateTime
 *
 * @property MusicArrangeItem[] $musicArrangeItems
 * @property MusicLibrary[] $musicNos
 */
class MusicArrange extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'music_arrange';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['arrangeNo', 'arrangeName', 'customerName', 'beginTime', 'endTime', 'arrangeLevel'], 'required'],
            [['beginDate', 'endDate', 'createTime', 'updateTime'], 'safe'],
            [['arrangeLevel'], 'integer'],
            [['arrangeNo'], 'string', 'max' => 20],
            [['arrangeName'], 'string', 'max' => 64],
            [['customerName'], 'string', 'max' => 32],
            [['beginTime', 'endTime'], 'string', 'max' => 10],
            [['arrangeNo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'arrangeNo' => '播期编号',
            'arrangeName' => '播期名称',
            'customerName' => '客户名称',
            'beginDate' => '开始日期',
            'endDate' => '结束日期',
            'beginTime' => '开始时间',
            'endTime' => '结束时间',
            'arrangeLevel' => '播期等级',
            'createTime' => '创建时间',
            'updateTime' => '修改时间',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {

                $this->createTime = Utils::defaultDate();
                $dbDate = substr($this->arrangeNo, 2, 8);
                $dbNo = (int)substr($this->arrangeNo, 10);
                RedisHelper::getRedis()->set(NoBuilder::ARRANGE_KEY, $dbNo);
                RedisHelper::getRedis()->set(NoBuilder::ARRANGE_DATE_KEY, $dbDate);
            }else{
                $this->updateTime = Utils::defaultDate();
            }
            return true;
        }
        return false;

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMusicArrangeItems()
    {
        return $this->hasMany(MusicArrangeItem::className(), ['arrangeNo' => 'arrangeNo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMusicNos()
    {
        return $this->hasMany(MusicLibrary::className(), ['musicNo' => 'musicNo'])->viaTable('music_arrange_item', ['arrangeNo' => 'arrangeNo']);
    }
//    public function getMusicArrange()
//    {
//        return $this->hasMany(MusicArrangeDevice::className(), ['arrangeNo' => 'arrangeNo']);
//    }
}

<?php

namespace app\models;

use app\utils\Utils;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "music_library".
 *
 * @property int $id
 * @property string $musicNo
 * @property string $musicName
 * @property int $musicSize
 * @property string $musicUrl
 * @property int $playTime
 * @property string $md5
 * @property string $createTime
 *
 * @property MusicArrangeItem[] $musicArrangeItems
 */
class MusicLibrary extends BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'music_library';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['musicNo', 'musicName', 'musicSize', 'musicUrl', 'playTime', 'md5'], 'required'],
            [['musicSize', 'playTime'], 'integer'],
            [['createTime'], 'safe'],
            [['musicNo'], 'string', 'max' => 20],
            [['musicName'], 'string', 'max' => 64],
            [['musicUrl'], 'string', 'max' => 60],
            [['md5'], 'string', 'max' => 32],
            [['musicNo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'musicNo' => '音乐编号',
            'musicName' => '音乐名称',
            'musicSize' => '音乐大小',
            'musicUrl' => '音乐Url',
            'playTime' => '播放时长',
            'md5' => 'Md5',
            'createTime' => '创建时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMusicArrangeItems()
    {
        return $this->hasMany(MusicArrangeItem::className(), ['musicNo' => 'musicNo']);
    }

}

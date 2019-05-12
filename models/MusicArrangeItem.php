<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "music_arrange_item".
 *
 * @property int $id
 * @property string $arrangeNo
 * @property string $musicNo
 *
 * @property MusicLibrary $musicNo0
 * @property MusicArrange $arrangeNo0
 */
class MusicArrangeItem extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'music_arrange_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'musicNo'], 'required'],
            [['arrangeNo', 'musicNo'], 'string', 'max' => 20],
            [['musicNo', 'arrangeNo'], 'unique', 'targetAttribute' => ['musicNo', 'arrangeNo']],
            [['musicNo'], 'exist', 'skipOnError' => true, 'targetClass' => MusicLibrary::className(), 'targetAttribute' => ['musicNo' => 'musicNo']],
            [['arrangeNo'], 'exist', 'skipOnError' => true, 'targetClass' => MusicArrange::className(), 'targetAttribute' => ['arrangeNo' => 'arrangeNo']],
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
            'musicNo' => '音乐编号',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMusicNo0()
    {
        return $this->hasOne(MusicLibrary::className(), ['musicNo' => 'musicNo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArrangeNo0()
    {
        return $this->hasOne(MusicArrange::className(), ['arrangeNo' => 'arrangeNo']);
    }
}

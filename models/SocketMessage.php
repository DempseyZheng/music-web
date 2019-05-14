<?php

namespace app\models;

use app\utils\Debugger;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "socket_message".
 *
 * @property int $id
 * @property string $devId
 * @property string $message
 */
class SocketMessage extends ActiveRecord
{
    public function doSave($runValidation = true){
        $result=  $this->save($runValidation);

        if (!$result){
            Debugger::toJson($this->getErrors(),'保存失败');
        }
        return $result;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'socket_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['devId', 'message'], 'required'],
            [['devId'], 'string', 'max' => 30],
            [['message'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'devId' => 'Dev ID',
            'message' => 'Message',
        ];
    }
}

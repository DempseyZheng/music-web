<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-3-15
 * Time: 下午8:32
 */

namespace app\utils;


use app\commands\WorkmanController;
use app\controllers\MusicDeviceController;
use app\models\MusicArrangeDevice;
use app\models\MusicDevice;
use app\models\MusicStore;
use app\models\SocketMessage;

class WebsocketUtil
{

    public static function sendMsg($devId, $message)
    {
        $msg = new SocketMessage();
        $msg->devId = $devId;
        $msg->message =Debugger::toJson($message,'发送消息') ;
        $msg->doSave();
    }


    public static function setReplyOK(\stdClass $replyObj)
    {
        $replyObj->v = new \stdClass();
        $replyObj->v->ret = 'ok';
    }

    public static function sendDevLog($devId, $logType)
    {
        $replyObj = self::newReply('devLog');

        $replyObj->v = new \stdClass();
        $replyObj->v->logType = $logType;
        self::sendMsg($devId, $replyObj);
    }

    public static function sendPublish($devId, $arrangeNo)
    {
        $replyObj = self::newReply('publish');

        $replyObj->v = new \stdClass();
        $replyObj->v->arrangeNo = $arrangeNo;
        self::sendMsg($devId, $replyObj);
    }

    public static function sendRestartApp($devId)
    {
        $replyObj = self::newReply('restartApp');

        self::sendMsg($devId, $replyObj);

    }

    public static function sendVolume($devId, $volume)
    {
        $replyObj = self::newReply('setVolume');

        $replyObj->v = new \stdClass();
        $replyObj->v->volume = $volume;
        Debugger::debug($volume);
        self::sendMsg($devId, $replyObj);
    }

    public static function newReply($c)
    {
        $replyObj = new \stdClass();
        $replyObj->c = $c;
        $replyObj->s = time();
        return $replyObj;
    }

    public static function newVReply($c)
    {
        $replyObj = new \stdClass();
        $replyObj->c = $c;
        $replyObj->s = time();
        $replyObj->v = new \stdClass();
        return $replyObj;
    }

    public static function pingMsg()
    {
        $replyObj = new \stdClass();
        $replyObj->c = 'PING';
        return Debugger::toJson($replyObj, '心跳');
    }

    public static function sendArrangeStatus($devId, $arrangeNo, $status)
    {
        $arrangeStatus = self::newVReply('arrangeStatus');
//      $arrangeStatus->v->arrangeNo=['201903200000001'];
        $arrangeStatus->v->arrangeNo = $arrangeNo;
        $arrangeStatus->v->status = $status;

        self::sendMsg($devId, $arrangeStatus);

    }

    public static function handleMsg($connection, $data)
    {
        $connection->lastMessageTime = time();

//        $replyMsg = $data;
        $data = Debugger::fromJson($data, $connection->getRemoteIp());
        if (empty($data)) {
//            $connection->send($replyMsg);
            return;
        }
        if (empty($data->c)) {
//            $connection->send($replyMsg);
            return;
        }
        if ($data->c === 'PONG') {
            return;
        }
        $replyObj = new \stdClass();
        $replyObj->c = $data->c;
        $replyObj->s = $data->s;
        switch ($data->c) {
            case 'regState':
                $connection->devId = $data->v->devId;

//                self::saveConnection($connection);

                $replyObj->v = new \stdClass();
                $replyObj->v->state = MusicDeviceController::getRegState($connection->devId);
                break;
            case 'logout':
//                $replyMsg = '{"v":{"ret":"ok"},"s":"1484792524947","c":"logout"}';
                WebsocketUtil::setReplyOK($replyObj);
                MusicDeviceController::logout($connection->devId);
                break;
            case 'storeInfo':
                $replyObj->v = new \stdClass();
                $device = MusicDBHelper::findDeviceStore($connection->devId);
                $replyObj->v->storeName = $device['storeName'];
                $replyObj->v->deviceName = $device['deviceName'];
                $replyObj->v->storeNo = $device['storeNo'];
                $replyObj->v->deviceNo = $device ['deviceNo'];
                break;
//            case 'devLog':
//                $replyMsg = '{"s":1484791838247,"c":"devLog","v":{"logType":0}}';
//
//                break;
            case 'arrangeProgress':
                $data->progress;
                $data->arrangeNo;
                break;
            case 'init':
                Debugger::debug($data->v->appVersion .
                    '=' .
                    $data->v->storageCard .
                    '=' .
                    $data->v->deviceSound);
                $store = MusicDBHelper::findDeviceStore($connection->devId);
                Debugger::log($store['deviceNo'], '设备编号');
                $deviceArranges = MusicArrangeDevice::findAll(['deviceNo' => $store['deviceNo']]);

                $replyObj->v = new \stdClass();
                $replyObj->v->configTime = time();
//                $config=new \stdClass();
//                $replyObj->v->config=$config;
                $arrangeList = [];

                foreach ($deviceArranges as $deviceArrange) {
                    $arrange = new \stdClass();
                    $arrange->arrangeNo = $deviceArrange->arrangeNo;
//                $arrange->status = $deviceArrange['arrangeStatus'];
                    $arrange->status = $deviceArrange->arrangeStatus;
                    $arrangeList[] = $arrange;
                }
                $replyObj->v->arrangeList = $arrangeList;

                $storeTime = 0;
                if ($store) {
                    if ($store['updateTime']) {
                        $storeTime = $store['updateTime'];
                    } else {
                        $storeTime = $store['createTime'];
                    }
                }
                Debugger::log($storeTime, '门店修改时间');
                $replyObj->v->storeModifyTime = Utils::strToMicroTime($storeTime);
                $replyObj->v->syncTime = Utils::micTime();

                break;

            default:
                return;
                break;
        }
        $connection->send(Debugger::toJson($replyObj, 'Re'));
    }

    public static function handleRestart(array $arr)
    {
        foreach ($arr as $item) {
            self::sendRestartApp($item['mac']);
        }
    }

    /**
     * @param $connection
     */
    public static function saveConnection($connection)
    {
        $obj = RedisHelper::getObj(Constants::CONNECTIONS_KEY);
        if (!$obj) {
            $obj = [];
        }
        $obj[] = $connection;
        RedisHelper::setObj(Constants::CONNECTIONS_KEY, $obj);
    }

    public static function delConnection($connection)
    {
        if (empty($connection->devId)) {
            return;
        }
        $obj = RedisHelper::getObj(Constants::CONNECTIONS_KEY);
        if (!$obj) {
            return;
        }
        foreach ($obj as $key => $conn) {
            if ($conn->devId === $connection->devId) {
                unset($obj[$key]);
                break;
            }
        }
    }

    public static function handleSetVolume(array $arr,$volume)
    {
        Debugger::debug($volume);
        foreach ($arr as $item) {
            self::sendVolume($item['mac'],$volume);
        }
    }

}

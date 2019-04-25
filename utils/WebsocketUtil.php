<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-3-15
 * Time: 下午8:32
 */

namespace app\utils;



class WebsocketUtil
{
    public static $worker;

    public static function sendMsg($devId, $msg)
    {
        $msg = Debugger::toJson($msg, 'SEND');
        foreach (self::$worker->connections as $connection) {
            if ($connection->devId === $devId) {
                $connection->send($msg);
                break;
            }
        }
    }
    public static function closeCon($devId)
    {

        foreach (self::$worker->connections as $connection) {
            if ($connection->devId === $devId) {
                $connection->close();
                break;
            }
        }
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

}

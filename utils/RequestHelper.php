<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-3-28
 * Time: 下午6:45
 */
namespace app\utils;

use Yii;

class RequestHelper
{
    public static function getRequest()
    {
        return Yii::$app->request;
}
    public static function successMsg()
    {
        return '{"flag":{"retCode":"0","retMsg":"success"}}';
    }
    public static  function successDetail($detail)
    {
        self::formatJson();
        return ['flag'=>['retCode'=>'0','retMsg'=>'success','retDetail'=>$detail]];
    }
    public static  function successData($data)
    {
        self::formatJson();
        return ['flag'=>['retCode'=>'0','retMsg'=>'success'],'data'=>$data];
    }
    public static  function successObj()
    {
        self::formatJson();
        return ['flag'=>['retCode'=>'0','retMsg'=>'success']];
    }
    public static  function errCodeMsg($code, $msg)
    {
        self::formatJson();
        return ['flag'=>['retCode'=>$code,'retMsg'=>$msg]];
    }
    public static  function errMsg( $msg)
    {
        self::formatJson();
        return ['flag'=>['retCode'=>'9009','retMsg'=>$msg]];
    }

    public static function formatJson()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }
}

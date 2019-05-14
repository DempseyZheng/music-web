<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-4-3
 * Time: 上午11:02
 */

namespace app\utils;


use Yii;

class RedisHelper
{
    public static function getRedis()
    {
        return Yii::$app->cache;
    }

    public static function get($key)
    {
        return self::getRedis()->get($key);
    }

    public static function set($key, $value)
    {
        return self::getRedis()->set($key, $value);
    }
    public static function getObj($key)
    {
        return unserialize(self::getRedis()->get($key));
    }
    public static function setObj($key, $value)
    {
        return serialize(self::getRedis()->set($key, $value));
    }
}

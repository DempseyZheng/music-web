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
      return  Yii::$app->cache;
}
}

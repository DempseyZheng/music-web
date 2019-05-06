<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-5-5
 * Time: 上午8:45
 */

namespace app\utils;


use app\models\MusicArrange;

class NoBuilder
{

    const ARRANGE_KEY='arrangeNo';
    const ARRANGE_DATE_KEY='arrangeDateNo';
    public static function getProNo()
    {
        $cacheNo = RedisHelper::getRedis()->get(self::ARRANGE_KEY);
        if (empty($cacheNo)) {
            $couponRule = DBHelper::newQuery()->from(MusicArrange::tableName())
                ->orderBy('id DESC')
                ->one();

            if ($couponRule) {
                $dbNo = (int)substr($couponRule['arrangeNo'], 2);
                $couponRuleNo = self::addZero(++$dbNo, 6);
                RedisHelper::getRedis()->set(self::ARRANGE_KEY, $couponRuleNo);
                return self::addArrangePre($couponRuleNo);
            }

            $couponRuleNo = '000001';
            RedisHelper::getRedis()->set(self::ARRANGE_KEY, $couponRuleNo);
            return self::addArrangePre($couponRuleNo);
        }

        $couponRuleNo = self::addZero(++$cacheNo, 6);
        RedisHelper::getRedis()->set(self::ARRANGE_KEY, $couponRuleNo);
        return self::addArrangePre($couponRuleNo);
    }

    public static function getArrangeNo()
    {

        $today = date('Ymd');
        $cacheNo = RedisHelper::getRedis()->get(self::ARRANGE_KEY);
        $cacheDate =  RedisHelper::getRedis()->get(self::ARRANGE_DATE_KEY);
        if (empty($cacheNo)) {
            $couponRule =  DBHelper::newQuery()->from(MusicArrange::tableName())
                ->orderBy('id DESC')
                ->one();

            if ($couponRule) {
                $dbDate = substr($couponRule['arrangeNo'], 2, 8);
                $dbNo = (int)substr($couponRule['arrangeNo'], 10);
                if ($today == $dbDate) {
                    $couponRuleNo = self::addZero(++$dbNo, 4);
                    $couponRuleDate = $today;

                    return self::addArrangePre($couponRuleDate . $couponRuleNo) ;
                }
            }

            $couponRuleNo = '0001';
            $couponRuleDate = $today;

            return self::addArrangePre($couponRuleDate . $couponRuleNo) ;
        }
        if ($today == $cacheDate) {
            $couponRuleNo = self::addZero(++$cacheNo, 4);
        } else {
            $couponRuleNo = '0001';
        }

        $couponRuleDate = $today;

        return self::addArrangePre($couponRuleDate . $couponRuleNo) ;
    }

    public static function addArrangePre($couponRuleNo)
    {
        return 'AN' . $couponRuleNo;
    }
    public static function addZero($num, $len)
    {
        while (strlen($num) < $len) {
            $num = '0' . $num;
        }
        return $num;
    }

}

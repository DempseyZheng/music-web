<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-3-12
 * Time: 下午8:45
 */

namespace app\utils;


class Utils
{
    public static function endWith($haystack, $needle)
    {
        return $needle === '' || substr_compare($haystack, $needle, -strlen($needle)) === 0;
    }

    public static function genRandomValue($len)
    {
        // 密码字符集，可任意添加你需要的字符
        $chars = array(
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        // 在 $chars 中随机取 $length 个数组元素键名
        $password = '';

        for ($i = 0; $i < $len; $i++) {
            $keys = array_rand($chars, 1);

            // 将 $length 个数组元素连接成字符串
            $password .= $chars[$keys];
        }
        return $password;
    }

    public static function genCouponNo()
    {
        return self::genRandomValue(32);
    }

    public static function getDBOffset($page, $rows)
    {
        return ($page - 1) * $rows;
    }

    public static function defaultDate()
    {
        return date("Y-m-d H:i:s");
    }

    public static function date($time)
    {
        return date("Y-m-d H:i:s", $time);
    }




    public static function micTime()
    {
        list($msec, $sec) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    }


    public static function getHost()
    {
        $scheme = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
        $url = $scheme . $_SERVER['HTTP_HOST'];
        return $url;
    }

    public static function strToMicroTime($usec)
    {
        $date = strtotime($usec);
        return (int)str_pad($date, 13, "0", STR_PAD_RIGHT); //不足13位。右边补0
    }

    public static function getRegCode()
    {
        $value = self::genRandomValue(12);
        $code = '';
        for ($i = 0; $i < strlen($value); $i++) {
            if ($i != 0 && $i % 4 == 0) {
                $code = $code . '-';
            }
            $code = $code . $value[$i];

        }
        return $code;
    }

    public static function changeFileName($path, $name)
    {
        return substr($path, 0, strrpos($path, '/')) . '/' . $name;
    }

    public static function rename($old, $new)
    {
        try {
            return rename($old, $new);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-3-3
 * Time: 下午4:00
 */
namespace app\utils;


class Debugger{
    static function getMilliseconds(){
        $mtimestamp= sprintf("%.3f",microtime(true));
        $timestamp = floor($mtimestamp); // 时间戳
        return round(($mtimestamp - $timestamp) * 1000); // 毫秒
    }

    public static  function debug($data){

            $title="dempsey";

        $stdout = fopen('php://stdout', 'w');
        fwrite($stdout,Utils::defaultDate()."." .self::getMilliseconds()  ." [$title]: ".$data."\n");   //为了打印出来的格式更加清晰，把所有数据都格式化成Json字符串
        fclose($stdout);
        return $data;
    }

 public static  function log($data,$title){
        if ($title==null){
            $title="dempsey";
        }
        $stdout = fopen('php://stdout', 'w');
        fwrite($stdout,Utils::defaultDate()."." .self::getMilliseconds()  ." [$title]: ".$data."\n");   //为了打印出来的格式更加清晰，把所有数据都格式化成Json字符串
        fclose($stdout);
        return $data;
    }
    public static  function toJson($data, $title){
        return self::log(json_encode($data,JSON_UNESCAPED_UNICODE),$title);
    }
    public static  function fromJson($data, $title){

        return json_decode(self::log($data,$title)) ;
    }


}


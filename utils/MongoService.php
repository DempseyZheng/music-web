<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-3-10
 * Time: 下午8:38
 */

namespace app\utils;





use MongoDB\BSON\ObjectId;

class MongoService
{
    public static function getDB()
    {
        $client=   new \MongoDB\Client("mongodb://localhost:27017");
        return   $client->basic;
    }

    public static function saveFile($fileCharater)
    {


        if ($fileCharater->isValid()) {
            $path = $fileCharater->getRealPath();
            Debugger::log($path.'='.md5_file($path),'路径');
            $filename =$fileCharater->getClientOriginalName();
            $file = fopen($path, 'rb');
            $bucket=    self::getDB()->selectGridFSBucket();
            $fileId=    $bucket->uploadFromStream($filename, $file);
            Debugger::log($fileId,'文件id');
            return $fileId;
        }
        return -1;

    }

    public static function deleteFile($id)
    {
        $bucket=    self::getDB()->selectGridFSBucket();
        $id = new ObjectId($id);
        $bucket->delete($id);
    }
    public static function getId($id)
    {
        return new ObjectId($id);
    }

    public static function insertFile($path, $filename)
    {
        Debugger::log($path, '路径');
        $file = fopen($path, 'rb');
        $bucket = MongoService::getDB()->selectGridFSBucket();
        $fileId = $bucket->uploadFromStream($filename, $file);
        Debugger::log($fileId, '文件id');
        return $fileId;
    }


}

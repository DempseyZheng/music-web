<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-4-3
 * Time: 上午11:41
 */

namespace app\utils;


use MongoDB\BSON\ObjectId;
use Yii;


class MongodbHelper
{
    public static function getMongodb()
    {
        return Yii::$app->mongodb;
    }
    public static function getId($id)
    {
        return new ObjectId($id);
    }
    public static function uploadFile($path)
    {
     $file=   self::getMongodb()->getFileCollection()->createUpload()->addFile($path)->complete();
     return $file['_id']->__toString();
    }

    public static function getFileString($id)
    {
      return  self::createDownload($id)->toString();
    }
    public static function getFileDoc($id)
    {
        return  self::createDownload($id)->getDocument();
    }

    public static function createDownload($id)
    {
        return  self::getMongodb()->getFileCollection()->createDownload(self::getId($id));
    }
}

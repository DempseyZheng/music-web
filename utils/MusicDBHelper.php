<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-5-14
 * Time: 下午1:49
 */

namespace app\utils;


use app\models\MusicArrange;
use app\models\MusicArrangeDevice;
use app\models\MusicDevice;
use app\models\MusicStore;

class MusicDBHelper extends DBHelper
{
    public static function findDeviceStore($mac)
    {
    return    DBHelper::newQuery()
            ->from(MusicDevice::tableName())
            ->where(['mac'=>$mac])
            ->leftJoin(MusicStore::tableName(),'music_store.storeNo = music_device.storeNo')
            ->one();
    }



}

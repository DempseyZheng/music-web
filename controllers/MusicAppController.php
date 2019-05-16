<?php

namespace app\controllers;

use app\models\MusicArrange;
use app\models\MusicArrangeDevice;
use app\models\MusicArrangeItem;
use app\models\MusicDevice;
use app\models\MusicLibrary;
use app\utils\DBHelper;
use app\utils\Debugger;
use app\utils\MongoService;
use app\utils\RequestHelper;
use app\utils\Utils;
use MongoDB\Driver\Exception\RuntimeException;
use yii\web\Controller;


class MusicAppController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {

    }

//    public function actionDownload()
//    {
//        $id = RequestHelper::getRequest()->get("id");
//        if (empty($id) || $id === 'null') {
//            RequestHelper::setStatusCode(404);
//            return '未找到该文件';
//        }
//        Debugger::log($id, '下载');
//        try {
//
//            $id = MongoService::getId($id);
//        } catch (\Exception $e) {
//            RequestHelper::setStatusCode(404);
//            return '未找到该文件';
//        }
//        try {
//
//            $bucket = MongoService::getDB()->selectGridFSBucket();
//            $file = $bucket->findOne(['_id' => $id]);
//            if ($file == null) {
//                RequestHelper::setStatusCode(404);
//                return '未找到该文件';
//            }
//        } catch (RuntimeException $e) {
//            RequestHelper::setStatusCode(500);
//            return 'Mongo服务器异常';
//        }
//        header("Content-type:application/octet-stream");
//        header("Content-Transfer-Encoding: binary");
//        header("Accept-Ranges:bytes");
//        header("Accept-Length:" . $file['length']);
//        header("Content-Disposition: attachment; filename=" . $file['filename']);
//        $stram = $bucket->openDownloadStream($id);
//
//        $filePath='/mnt/wd/upload/files/'.Utils::micTime();
//copy($stram,$filePath);
//
//        $fileHandle=fopen($filePath,"rb");
//        while (!feof($fileHandle)) {
//
////从文件指针 handle 读取最多 length 个字节
//
//            echo fread($fileHandle, 32768);
//
//        }
//
//        fclose($fileHandle);
//
//
//    }

    public function actionDownload($id)
    {
        if (!empty($id) && strlen($id) == 24) {
//            $mongo = new \MongoClient('mongodb://localhost:27017');
//            $db = $mongo->selectDB('basic');
//            $model = $db->getGridFS()->findOne(['_id' => new \MongoId($id)]);
//            $fp= $model->getResource();
//            $model = $model->file;
            $id = MongoService::getId($id);
            $bucket = MongoService::getDB()->selectGridFSBucket();
            $model = $bucket->findOne(['_id' => $id]);
            $fp = $bucket->openDownloadStream($id);


            $size = $model['length'];
            $begin = 0;
            $end = $size - 1;

            if (isset($_SERVER['HTTP_RANGE'])) {
                header('HTTP/1.1 206 Partial Content');
                if (preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches)) {
                    // 读取文件，起始节点
                    $begin = intval($matches[1]);
                    // 读取文件，结束节点
                    if (!empty($matches[2])) {
                        $end = intval($matches[2]);
                    }
                }
                header('Content-Range: bytes ' . $begin . '-' . $end . '/' . $size);
            } else {
                header('HTTP/1.1 200 OK');
            }

            header('Cache-control: public');
            header('Pragma: no-cache');
            header('Accept-Ranges: bytes');
//            header('Content-Type: ' . $model['contentType']);
            header('Content-Type: application/x-download');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length:' . (($end - $begin) + 1));
            header('Content-Disposition: attachment;filename="' . $model['filename'] . '"');
            header('ETag:'. md5($id));

            fseek($fp, $begin);
            while (!feof($fp)){
                echo fread($fp, 8192);
                ob_flush();
                flush();
            }
        }
}

    public function actionRegister()
    {
        $req = RequestHelper::getRequest();
        $devId = $req->post('devId');
        $regCode = $req->post('registerCode');
        Debugger::debug($devId . '==' . $regCode);

        $row = MusicDevice::findOne(['mac' => $regCode]);

        if ($row) {
            $row->mac = $devId;
            $row->registerStatus = 1;
            $row->update();

            return RequestHelper::successMsg();
        }
        return RequestHelper::errMsg('注册失败');
    }

    /**
     * 下载播期
     */
    public function actionArrange()
    {
//        $deviceNo = RequestHelper::getRequest()->post('deviceNo');
        $arrangeList = RequestHelper::getRequest()->post('arrangeList');

//        $devices = MusicArrangeDevice::findAll(['deviceNo' =>$deviceNo]);
//        $ans = [];
//        foreach ($devices as $device) {
//            $ans[] = $device->arrangeNo;
//        }

        $arranges = DBHelper::newQuery()
            ->from(MusicArrange::tableName())
            ->where(['in', 'arrangeNo', $arrangeList])
            ->all();

        $musics = DBHelper::newQuery()
            ->from(MusicArrangeItem::tableName())
            ->where(['in', 'arrangeNo', $arrangeList])
            ->leftJoin(MusicLibrary::tableName(), 'music_arrange_item.musicNo = music_library.musicNo')
            ->all();

        foreach ($arranges as &$arrange) {
            $arrMusic = [];
            $totalSize = 0;
            foreach ($musics as &$music) {
                if ($music['arrangeNo'] === $arrange['arrangeNo']) {
                    $totalSize += $music['musicSize'];
                    $music['musicUrl'] = Utils::getHost() . "/music-app/" . $music['musicUrl'];
                    $arrMusic[] = $music;
                    continue;
                }
            }
            $arrange['musics'] = $arrMusic;
            $arrange ['totalSize'] = $totalSize;
            $arrange ['createTime'] = strtotime($arrange ['createTime']);
        }

        return RequestHelper::successData($arranges);
    }

    public function actionUploadDownloadStatus()
    {
        $downloadStatus = RequestHelper::getRequest()->post();
     if ($downloadStatus['state']==0){

        $downloadStatus['errMsg'];
     }
        $downloadStatus['arrangeNo'];
        $downloadStatus['devId'];
        Debugger::toJson($downloadStatus, 'actionUploadDownloadStatus');

        return RequestHelper::successMsg();
    }
}

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
    public function actionDownload()
    {
        $id = RequestHelper::getRequest()->get("id");
        if (empty($id)||$id==='null'){
            RequestHelper::setStatusCode(404);
            return '未找到该文件';
        }
        Debugger::log($id,'下载');
        try{

        $id = MongoService::getId($id);
        }catch (\Exception $e){
            RequestHelper::setStatusCode(404);
            return '未找到该文件';
        }
        try{

        $bucket = MongoService::getDB()->selectGridFSBucket();
        $file = $bucket->findOne(['_id' => $id]);
        if ($file==null){
            RequestHelper::setStatusCode(404);
            return '未找到该文件';
        }
        }catch (RuntimeException $e){
            RequestHelper::setStatusCode(500);
            return 'Mongo服务器异常';
        }
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Accept-Length:".$file['length']);
        header("Content-Disposition: attachment; filename=".$file['filename']);
        $stram = $bucket->openDownloadStream($id);
        $img = stream_get_contents($stram);

        return $img;
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

        return Debugger::toJson(RequestHelper::successData($arranges),'下载播期') ;
    }
}

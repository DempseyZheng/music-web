<?php

namespace app\controllers;

use app\models\MusicArrange;
use app\models\MusicArrangeDevice;
use app\models\MusicArrangeItem;
use app\models\MusicDevice;
use app\models\MusicLibrary;
use app\models\MusicStore;
use app\models\SocketMessage;
use app\utils\DBHelper;
use app\utils\Debugger;
use app\utils\MusicDBHelper;
use app\utils\RedisHelper;
use app\utils\Utils;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class TestController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
//                'only' => ['logout'],
                'rules' => [
                    [
//                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
//            'error' => [
//                'class' => 'app\utils\MyErrorAction',
//            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
//    return  Debugger::debug(Utils::secToTime(3600*22+60*55+1));
//     $arr=   DBHelper::newQuery()
//            ->from(MusicDevice::tableName())
//            ->where(['deviceNo'=>'D1003'])
//            ->leftJoin(MusicStore::tableName(),'music_store.storeNo = music_device.storeNo')
//            ->one();
//  return   Debugger::debug($arr['storeName']);
//        $replyObj =new \stdClass();
//        $replyObj->v = new \stdClass();
//        $device = MusicDBHelper::findDeviceStore('44:2c:05:be:d7:66');
//        $replyObj->v->storeName = $device['storeName'];
//        $replyObj->v->deviceName = $device['deviceName'];
//        $replyObj->v->storeNo = $device['storeNo'];
//        $replyObj->v->deviceNo = $device ['deviceNo'];

//        $store = MusicDBHelper::findDeviceStore('44:2c:05:be:d7:66');
//        $storeTime = 0;
//        if ($store) {
//            if ($store['updateTime']) {
//                $storeTime = $store['updateTime'];
//            } else {
//                $storeTime = $store['createTime'];
//            }
//        }
//        Debugger::log($storeTime, '门店修改时间');

//        return Debugger::toJson(MusicDBHelper::findDeviceArrange('44:2c:05:be:d7:66'),'d');
//        Debugger::debug('s');
//    $arr  =  MusicArrangeDevice::findAll(['deviceNo' => 'D1003']);

//        RedisHelper::getRedis()->set('serialize2',serialize($arr));
//     $ser=   RedisHelper::getObj('serialize2');
//     Debugger::debug($ser);
//  $arr2=   unserialize($ser);
//        foreach ($arr2 as $item) {
//            Debugger::debug($item->arrangeNo);
//  }
//        $obj =[1,2,3];
//
//        foreach ($obj as $key=> $conn) {
//            if ($conn==2) {
//                unset($obj[$key]);
//                break;
//            }
//        }
//        $obj[0];


//        $deviceArranges=  DBHelper::newQuery()
//            ->from(MusicArrangeDevice::tableName())
//            ->where(['deviceNo'=>'D1003'])
//            ->leftJoin(MusicArrangeItem::tableName(),'music_arrange_item.arrangeNo = music_arrange_device.arrangeNo')
//            ->leftJoin(MusicLibrary::tableName(),'music_arrange_item.musicNo = music_library.musicNo')
//            ->all();
//        foreach ($deviceArranges as $deviceArrange) {
//
//        }
//
//    $devices=    MusicArrangeDevice::findAll(['deviceNo'=>'D1003']);
//
//        $ans=[];
//        foreach ($devices as $device) {
//     $ans[]=$device->arrangeNo;
//    }
//    $arranges=    DBHelper::newQuery()
//            ->from(MusicArrange::tableName())
//            ->where(['in','arrangeNo',$ans])
//            ->all();
//
//     $musics=   DBHelper::newQuery()
//            ->from(MusicArrangeItem::tableName())
//            ->where(['in','arrangeNo',$ans])
//            ->leftJoin(MusicLibrary::tableName(),'music_arrange_item.musicNo = music_library.musicNo')
//            ->all();
//
//        foreach ($arranges as &$arrange) {
//            $arrMusic = [];
//            $totalSize = 0;
//            foreach ($musics as &$music) {
//                if ($music['arrangeNo'] === $arrange['arrangeNo']) {
//                    $totalSize += $music['musicSize'];
//                    $music['musicUrl'] = Utils::getHost() . "/music-app/" . $music['musicUrl'];
//                    $arrMusic[] = $music;
//                    continue;
//                }
//            }
//            $arrange['musics'] = $arrMusic;
//            $arrange ['totalSize']  = $totalSize;
//            $arrange ['createTime']  = strtotime($arrange ['createTime'] );
//        }
//
//return Debugger::toJson($arranges,'');
//        return $this->render('index');

        MusicArrangeDevice::updateAll(['pubStatus'=>0],['id'=>[4,5,6]]);
//        MusicArrangeDevice::findAll(['id'=>[4,5,6]]);
//     DBHelper::newQuery()
//         ->from(MusicArrangeDevice::tableName())
//         ->where(['id'=>[4,5,6]])
//         ->all();
        return $this->render('index');
    }

}

<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-4-2
 * Time: 下午1:44
 */

namespace app\commands;


use app\controllers\MusicDeviceController;
use app\models\SocketMessage;
use app\utils\Constants;
use app\utils\Debugger;
use app\utils\RedisHelper;
use app\utils\Utils;
use app\utils\WebsocketUtil;

use PHPSocketIO\SocketIO;
use Workerman\Lib\Timer;
use Workerman\Worker;
use yii\console\Controller;
use yii\helpers\Console;

define('HEARTBEAT_TIME', 60);
global $worker;

class WorkmanController extends Controller
{
    public $send;
    public $daemon;
    public $gracefully;

    // 这里不需要设置，会读取配置文件中的配置
    public $config = [];
    private $ip = '0.0.0.0';
    private $port = '20002';


    //<--web-->
    // 全局数组保存uid在线数据
    public $uidConnectionMap = array();
// 记录最后一次广播的在线用户数
    public $last_online_count = 0;
// 记录最后一次广播的在线页面数
    public $last_online_page_count = 0;
    public $sender_io;

    public function options($actionID)
    {
        return ['send', 'daemon', 'gracefully'];
    }

    public function optionAliases()
    {
        return [
            's' => 'send',
            'd' => 'daemon',
            'g' => 'gracefully',
        ];
    }

    public function actionIndex()
    {
        if ('start' == $this->send) {
            try {
                $this->start($this->daemon);
            } catch (\Exception $e) {
                $this->stderr($e->getMessage() . "\n", Console::FG_RED);
            }
        } else if ('stop' == $this->send) {
            $this->stop();
        } else if ('restart' == $this->send) {
            $this->restart();
        } else if ('reload' == $this->send) {
            $this->reload();
        } else if ('status' == $this->send) {
            $this->status();
        } else if ('connections' == $this->send) {
            $this->connections();
        }
    }
    public function initWebWorker()
    {
        $this->sender_io = new SocketIO(2120);
// 客户端发起连接事件时，设置连接socket的各种事件回调
        $this->sender_io->on('connection', function ($socket) {
            // 当客户端发来登录事件时触发
            Debugger::debug('connection');
            $socket->on('login', function ($uid) use ($socket) {

                $uidConnectionMap = $this->uidConnectionMap;
                $last_online_count = $this->last_online_count;
                $last_online_page_count = $this->last_online_page_count;
                // 已经登录过了
                if (isset($socket->uid)) {
                    return;
                }
                // 更新对应uid的在线数据
                $uid = (string)$uid;
                if (!isset($uidConnectionMap[$uid])) {
                    $uidConnectionMap[$uid] = 0;
                }
                // 这个uid有++$uidConnectionMap[$uid]个socket连接
                ++$uidConnectionMap[$uid];
                // 将这个连接加入到uid分组，方便针对uid推送数据
                $socket->join($uid);
                $socket->uid = $uid;
                // 更新这个socket对应页面的在线数据
//                $socket->emit('update_online_count', "当前<b>{$last_online_count}</b>人在线，共打开<b>{$last_online_page_count}</b>个页面");
            });

            // 当客户端断开连接是触发（一般是关闭网页或者跳转刷新导致）
            $socket->on('disconnect', function () use ($socket) {
                Debugger::debug('disconnect');
                if (!isset($socket->uid)) {
                    return;
                }
                $uidConnectionMap=$this->uidConnectionMap;
                // 将uid的在线socket数减一
                if (--$uidConnectionMap[$socket->uid] <= 0) {
                    unset($uidConnectionMap[$socket->uid]);
                }
            });
        });

// 当$sender_io启动后监听一个http端口，通过这个端口可以给任意uid或者所有uid推送数据
        $sender_io = $this->sender_io;
        $this->sender_io->on('workerStart', function () use ($sender_io) {
            // 监听一个http端口
//            $sender_io2= $sender_io;
            $inner_http_worker = new Worker('http://0.0.0.0:2121');
            // 当http客户端发来数据时触发
            $inner_http_worker->onMessage = function ($http_connection, $data) use ($sender_io) {
                $uidConnectionMap=$this->uidConnectionMap;
                $_POST = $_POST ? $_POST : $_GET;
                // 推送数据的url格式 type=publish&to=uid&content=xxxx
                switch (@$_POST['type']) {
                    case 'publish':
//                        global $sender_io;
                        $to = @$_POST['to'];
                        $_POST['content'] = htmlspecialchars(@$_POST['content']);
                        // 有指定uid则向uid所在socket组发送数据
                        if ($to) {
                            $sender_io->to($to)->emit('new_msg', $_POST['content']);
                            // 否则向所有uid推送数据
                        } else {
                            $sender_io->emit('new_msg', @$_POST['content']);
                        }
                        // http接口返回，如果用户离线socket返回fail
                        if ($to && !isset($uidConnectionMap[$to])) {
                            return $http_connection->send('offline');
                        } else {
                            return $http_connection->send('ok');
                        }
                }
                return $http_connection->send('fail');
            };
            // 执行监听
            $inner_http_worker->listen();


        });
    }
    public function initWorker()
    {
        $this->initWebWorker();
        $ip = isset($this->config['ip']) ? $this->config['ip'] : $this->ip;
        $port = isset($this->config['port']) ? $this->config['port'] : $this->port;
//     global   $worker ;
        $worker = new Worker("websocket://{$ip}:{$port}/accv-music-websocket/device");
        $worker->uidConnections = array();
        // 4 processes
        $worker->count = 1;

        $worker->onWorkerStart = function ($worker) {
//            WebsocketUtil::$worker = $worker;

            $this->innerWorker($worker);

//            Timer::add(1, function () use ($worker) {
//                $time_now = time();
//         $arr=  SocketMessage::find()->all();
//
//                foreach ($worker->connections as $connection) {
//                    if ($arr) {
//                        foreach ($arr as $item) {
//                            if ($item->devId === $connection->devId) {
//                                $connection->send($item->message);
//                                $item->delete();
//                                break;
//                            }
//                        }
//                    }
//                    // 上次通讯时间间隔大于心跳间隔，则认为客户端已经下线，关闭连接
//                    if ($time_now - $connection->lastMessageTime > HEARTBEAT_TIME) {
//                        echo "Client ip {$connection->getRemoteIp()} timeout!!!\n";
//                        $connection->close();
//                    }
//                }
//            });

            Timer::add(30, function () use ($worker) {

                foreach ($worker->connections as $connection) {
                    $connection->send(WebsocketUtil::pingMsg());
                }
            });
        };
        // Emitted when new connection come
        $worker->onConnect = function ($connection) {
            $connection->lastMessageTime = time();
            echo "new connection from ip " . $connection->getRemoteIp() . "\n";
        };


        // Emitted when connection closed
        $worker->onClose = function ($connection) use ($worker) {
            if(isset($connection->devId))
            {
                // 连接断开时删除映射
                unset($worker->uidConnections[$connection->devId]);
            }

            echo "connection closed from ip {$connection->getRemoteIp()} =".count($worker->uidConnections)." \n";
        };
        // Emitted when data received
        $worker->onMessage = function ($connection, $data) use ($worker) {
            $data = Debugger::fromJson($data, $connection->getRemoteIp());
            if (empty($data)) {
//            $connection->send($replyMsg);
                return;
            }
            if (empty($data->c)) {
//            $connection->send($replyMsg);
                return;
            }
            if ($data->c === 'PONG') {
                return;
            }
            if ($data->c==='regState') {
                $worker->uidConnections[ $data->v->devId] = $connection;
               Debugger::debug('连接数量:'.count($worker->uidConnections));
            }
            WebsocketUtil::handleMsg($connection, $data);
        };
    }
public function innerWorker($worker){
    // 监听一个http端口
//            $sender_io2= $sender_io;
    $inner_http_worker = new Worker('http://0.0.0.0:20003');
    // 当http客户端发来数据时触发
    $inner_http_worker->onMessage = function ($http_connection, $data) use ($worker) {
        $uidConnectionMap=$worker->uidConnections;

        $_POST = $_POST ? $_POST : $_GET;
        // 推送数据的url格式 type=publish&to=uid&content=xxxx
        $postData=Debugger::fromJson( $_POST['data'],'postData');
        $sendMsg='<发送失败.>';
        switch ($postData->type) {
            case 'publish':
                $to = $postData->to;
//                $_POST['content'] = htmlspecialchars(@$_POST['content']);
                // 有指定uid则向uid所在socket组发送数据
                if ($to) {
                    $this->sendMessageByUid($worker,$to,$postData->content);
                    // 否则向所有uid推送数据
                } else {
//                    $sender_io->emit('new_msg', @$_POST['content']);
                }
                // http接口返回，如果用户离线socket返回fail
                if ($to && !isset($uidConnectionMap[$to])) {
                    $sendMsg='<发送失败:离线> ';
                } else {
                    $sendMsg='<发送成功> ';
                }
        }

        return $http_connection->send($sendMsg);
    };
    // 执行监听
    $inner_http_worker->listen();

}
    public function sendMessageByUid($worker,$uid, $message)
    {

        if (isset($worker->uidConnections[$uid])) {
            $connection = $worker->uidConnections[$uid];
            $connection->send($message);
            return true;
        }
        return false;
    }

    /**
     * workman websocket start
     */
    public function start()
    {
        $this->initWorker();

        // 重置参数以匹配Worker
        global $argv;
        $argv[0] = $argv[1];
        $argv[1] = 'start';
        if ($this->daemon) {
            $argv[2] = '-d';
        }

        // Run worker
        Worker::runAll();
    }

    /**
     * workman websocket restart
     */
    public function restart()
    {
        $this->initWorker();
        // 重置参数以匹配Worker
        global $argv;
        $argv[0] = $argv[1];
        $argv[1] = 'restart';
        if ($this->daemon) {
            $argv[2] = '-d';
        }

        if ($this->gracefully) {
            $argv[2] = '-g';
        }

        // Run worker
        Worker::runAll();
    }

    /**
     * workman websocket stop
     */
    public function stop()
    {
        $this->initWorker();

        // 重置参数以匹配Worker
        global $argv;
        $argv[0] = $argv[1];
        $argv[1] = 'stop';
        if ($this->gracefully) {
            $argv[2] = '-g';
        }

        // Run worker
        Worker::runAll();
    }

    /**
     * workman websocket reload
     */
    public function reload()
    {
        $this->initWorker();
        // 重置参数以匹配Worker
        global $argv;
        $argv[0] = $argv[1];
        $argv[1] = 'reload';
        if ($this->gracefully) {
            $argv[2] = '-g';
        }

        // Run worker
        Worker::runAll();
    }

    /**
     * workman websocket status
     */
    public function status()
    {
        $this->initWorker();
        // 重置参数以匹配Worker
        global $argv;
        $argv[0] = $argv[1];
        $argv[1] = 'status';
        if ($this->daemon) {
            $argv[2] = '-d';
        }

        // Run worker
        Worker::runAll();
    }

    /**
     * workman websocket connections
     */
    public function connections()
    {
        $this->initWorker();
        // 重置参数以匹配Worker
        global $argv;
        $argv[0] = $argv[1];
        $argv[1] = 'connections';

        // Run worker
        Worker::runAll();
    }


    public static function sendMessage($devId, $msg)
    {
        global $wsWorker;
        foreach ($wsWorker->connections as $connection) {
            if ($connection->devId === $devId) {
                $connection->send($msg);
                break;
            }
        }
    }

}

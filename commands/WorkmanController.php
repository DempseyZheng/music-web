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

    public function initWorker()
    {
        $ip = isset($this->config['ip']) ? $this->config['ip'] : $this->ip;
        $port = isset($this->config['port']) ? $this->config['port'] : $this->port;
//     global   $worker ;
        $worker = new Worker("websocket://{$ip}:{$port}/accv-music-websocket/device");

        // 4 processes
        $worker->count = 1;

        $worker->onWorkerStart = function ($worker) {
//            WebsocketUtil::$worker = $worker;


            Timer::add(1, function () use ($worker) {
                $time_now = time();
         $arr=  SocketMessage::find()->all();

                foreach ($worker->connections as $connection) {
                    if ($arr) {
                        foreach ($arr as $item) {
                            if ($item->devId === $connection->devId) {
                                $connection->send($item->message);
                                $item->delete();
                                break;
                            }
                        }
                    }
                    // 上次通讯时间间隔大于心跳间隔，则认为客户端已经下线，关闭连接
                    if ($time_now - $connection->lastMessageTime > HEARTBEAT_TIME) {
                        echo "Client ip {$connection->getRemoteIp()} timeout!!!\n";
                        $connection->close();
                    }
                }
            });
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
        $worker->onClose = function ($connection) {
//WebsocketUtil::delConnection($connection);
            echo "connection closed from ip {$connection->getRemoteIp()}\n";
        };
        // Emitted when data received
        $worker->onMessage = function ($connection, $data) {
            WebsocketUtil::handleMsg($connection, $data);
        };
    }

    public function sendMessageByUid($uid, $message)
    {
        global $worker;
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

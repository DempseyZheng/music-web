<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\utils\Debugger;
use PHPSocketIO\SocketIO;
use Workerman\Lib\Timer;
use Workerman\Worker;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SocketIoController extends Controller
{
    public $send;
    public $daemon;
    public $gracefully;
    public $arr = ['hello'];
    // 全局数组保存uid在线数据
    public $uidConnectionMap = array();
// 记录最后一次广播的在线用户数
    public $last_online_count = 0;
// 记录最后一次广播的在线页面数
    public $last_online_page_count = 0;
    public $sender_io;

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
        } else if ('status' == $this->send) {
            $this->status();
        }

    }

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

    public function initWorker()
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
                $socket->emit('update_online_count', "当前<b>{$last_online_count}</b>人在线，共打开<b>{$last_online_page_count}</b>个页面");
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
}

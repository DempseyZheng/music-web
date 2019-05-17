<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\utils\Debugger;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    public $send;
    public $daemon;
    public $gracefully;
    public $arr=['hello'];
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */

    public function actionIndex($message = 'hello world')
    {
        if ('start' == $this->send) {
          Debugger::debug($this->arr[0]);
        }else{

        echo $message . "\n";
        }

        return ExitCode::OK;
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
}

<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-4-6
 * Time: 下午4:57
 */

namespace app\controllers;


use app\utils\Debugger;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Controller;

class BaseController extends Controller
{
    public $access;

    public function __construct($id, Module $module, array $config = [])
    {
        $this->access = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ]
        ];
        parent::__construct($id, $module, $config);
    }
}

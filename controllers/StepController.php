<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-4-25
 * Time: 上午11:09
 */

namespace app\controllers;


use yii\web\Controller;

class StepController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}

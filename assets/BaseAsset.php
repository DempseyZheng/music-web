<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-4-23
 * Time: 下午7:32
 */

namespace app\assets;


use yii\web\AssetBundle;

class BaseAsset extends AssetBundle
{
    public $jsOptions=['position'=>\yii\web\View::POS_HEAD];
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}

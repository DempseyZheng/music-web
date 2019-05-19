<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BsTabsAsset extends BaseAsset
{


    public $css = [
        'css/b.tabs.css',
//        'http://www.jeasyui.com/easyui/themes/default/easyui.css',
    ];
    public $js = [
        'js/b.tabs.js',
//        'js/jquery.easyui.min.js'
    ];

}

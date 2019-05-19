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
class SidebarAsset extends BaseAsset
{


    public $css = [
//        'css/sidebar/custom.css',
//        'css/sidebar/jquery.mCustomScrollbar.min.css',
        'css/sidebar/side.css',
    ];
    public $js = [
//        'js/sidebar/custom.js',
//        'js/sidebar/jquery.mCustomScrollbar.concat.min.js',
        'js/sidebar/side.js',
    ];

}

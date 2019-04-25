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
class IndexAsset extends BaseAsset
{


    public $css = [
        'css/site.css',
        'css/admin/font-awesome.css',
//        'css/admin/ionicons.min.css',
        'css/admin/AdminLTE.css',
        'css/admin/_all-skins.min.css',
        'css/admin/morris.css',
        'css/admin/jquery-jvectormap.css',
        'css/admin/bootstrap-datepicker.min.css',
        'css/admin/daterangepicker.css',
        'css/admin/bootstrap3-wysihtml5.min.css',
    ];


    public $js = [
        'js/bootstrap.min.js',
        'js/admin/raphael.min.js',
        'js/admin/morris.min.js',
        'js/admin/jquery.sparkline.min.js',
        'js/admin/jquery-jvectormap-1.2.2.min.js',
        'js/admin/jquery-jvectormap-world-mill-en.js',
        'js/admin/jquery.knob.min.js',
        'js/admin/moment.min.js',
        'js/admin/daterangepicker.js',
        'js/admin/bootstrap-datepicker.min.js',
        'js/admin/bootstrap3-wysihtml5.all.min.js',
        'js/admin/jquery.slimscroll.min.js',
        'js/admin/fastclick.js',
        'js/admin/adminlte.min.js',
//        'js/admin/dashboard.js',
        'js/admin/demo.js',
    ];

}

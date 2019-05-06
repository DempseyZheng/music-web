<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-4-3
 * Time: 下午1:27
 */

namespace app\assets;



class JqueryUploadAsset extends BaseAsset
{

    public $css = [
       'css/jquery.fileupload.css'
    ];
    public $js = [
        'js/upload/jquery.ui.widget.js',
        'js/upload/jquery.iframe-transport.js',
        'js/upload/jquery.fileupload.js',
        'js/upload/upload.js',
    ];

}

<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-4-3
 * Time: 下午1:27
 */

namespace app\assets;



class BootstrapTableAsset extends BaseAsset
{

    public $css = [
       'https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.css'
    ];
    public $js = [
        'https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.js',
//        "https://unpkg.com/bootstrap-table@1.14.2/dist/extensions/editable/bootstrap-table-editable.min.js"
    ];

}

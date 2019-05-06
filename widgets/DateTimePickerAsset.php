<?php
/**
 * @copyright Copyright (c) 2013-2017 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace app\widgets;

use app\assets\BaseAsset;
use yii\web\AssetBundle;

/**
 * DateTimePickerAsset
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\datetimepicker
 */
class DateTimePickerAsset extends BaseAsset
{

    public $css = [
        'css/bootstrap-datetimepicker.min.css'
    ];

    public $js = [
        'js/bootstrap-datetimepicker.min.js'
    ];


}

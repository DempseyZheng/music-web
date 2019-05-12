<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-3-29
 * Time: 下午5:33
 */

namespace app\widgets;


use app\utils\Debugger;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class DynamicSearchInput extends InputWidget
{
    public $template = "{input}{button}";
    public $containerOptions = [];
    public $searchType;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        Html::addCssClass($this->options, 'form-control');
        Html::addCssClass($this->containerOptions, 'input-group');
    }

    public function run()
    {

        $input = $this->hasModel()
            ? Html::activeTextInput($this->model, $this->attribute, $this->options)
            : Html::textInput($this->name, $this->value, $this->options);

        $pickerAddon = Html::tag('span', '<span  class="glyphicon glyphicon-search" ></span>', ['class' => 'input-group-addon', 'style' => 'cursor:pointer','onclick'=>'onSearch(this,'.$this->searchType.')']);
        $input = Html::tag(
            'div',
            strtr($this->template, ['{input}' => $input, '{button}' => $pickerAddon]),
            $this->containerOptions
        );
        echo $input;

    }
}
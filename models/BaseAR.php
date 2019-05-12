<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-5-12
 * Time: 下午1:57
 */

namespace app\models;


use app\utils\Debugger;
use app\utils\Utils;
use yii\db\ActiveRecord;

class BaseAR extends ActiveRecord
{

    public function setDefaultData($that)
    {
        $that->setAttribute('createTime',Utils::defaultDate());
    }

    public function doSave(){
      $result=  $this->save();

      if (!$result){
          Debugger::toJson($this->getErrors(),'保存失败');
      }
      return $result;
    }
    protected  function doBeforeSave(){}

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->createTime = Utils::defaultDate();

            }else{
                $this->updateTime = Utils::defaultDate();
                $this->doBeforeSave();
            }
            return true;
        }
        return false;
    }
}

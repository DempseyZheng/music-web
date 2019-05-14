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
    public function doSave($runValidation = true){
      $result=  $this->save($runValidation);

      if (!$result){
          Debugger::toJson($this->getErrors(),'保存失败');
      }
      return $result;
    }
    protected  function doBeforeSave(){}

    public function beforeSave($insert)
    {
//        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->createTime = Utils::defaultDate();
                $this->doBeforeSave();
            }else{
                $this->updateTime = Utils::defaultDate();
            }
            return true;
//        }
//        return false;
    }

    public static function multiDelete($ids)
    {
       return self::deleteAll(['in','id', $ids]);
    }
}

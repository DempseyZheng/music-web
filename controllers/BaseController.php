<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-4-6
 * Time: 下午4:57
 */

namespace app\controllers;


use app\models\BaseModel;
use app\utils\DBHelper;
use app\utils\Debugger;
use app\utils\RequestHelper;
use Exception;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\widgets\ActiveForm;

class BaseController extends Controller
{
    public $access;

    public function __construct($id, Module $module, array $config = [])
    {
        $this->access = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ]
        ];
        parent::__construct($id, $module, $config);
    }

    protected function multipleCreate($modelCustomer, $modelsAddress, $clsName, $call)
    {
        $error = '';
        if ($modelCustomer->load(Yii::$app->request->post())) {

            $modelsAddress = BaseModel::createMultiple($clsName);
            BaseModel::loadMultiple($modelsAddress, Yii::$app->request->post());

            // validate all models
            $valid = $modelCustomer->validate();

            $valid = BaseModel::validateMultiple($modelsAddress) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                        foreach ($modelsAddress as $modelAddress) {
                            $modelAddress = call_user_func($call, $modelCustomer, $modelAddress);
                            if (!($flag = $modelAddress->save(false))) {
                                $modelAddress->error;
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelCustomer->id]);

                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    $error = $e->getMessage();
                    Debugger::debug($error);
                }
            } else {
                foreach ($modelsAddress as $modelAddress) {
                    $modelAddress->errors;
                }
            }
        }
        return [$modelCustomer, $modelsAddress, $error];
    }

    protected function multipleUpdate($modelCustomer, $modelsAddress, $clsName, $call)
    {
        $error = '';
        if ($modelCustomer->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsAddress, 'id', 'id');
            $modelsAddress = BaseModel::createMultiple($clsName, $modelsAddress);
            BaseModel::loadMultiple($modelsAddress, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsAddress, 'id', 'id')));

            // validate all models
            $valid = $modelCustomer->validate();
            $valid = BaseModel::validateMultiple($modelsAddress) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                        if (!empty($deletedIDs)) {
//                            Address::deleteAll(['id' => $deletedIDs]);
                            call_user_func($call, ['id' => $deletedIDs]);
                        }
                        foreach ($modelsAddress as $modelAddress) {
//                            $modelAddress->customer_id = $modelCustomer->id;
                            if (!($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelCustomer->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    $error = $e->getMessage();
                }
            }
        }
        return [$modelCustomer, $modelsAddress, $error];
    }

    protected function handleQuery($tbName, $colNo, $colName)
    {
        $limit = RequestHelper::getRequest()->get('limit');
        $offset = RequestHelper::getRequest()->get('offset');
        $deviceNo = RequestHelper::getRequest()->get('queryNo');
        $deviceName = RequestHelper::getRequest()->get('queryName');

        if (empty($deviceNo) && empty($deviceName)) {
            return DBHelper::limitAll($limit,
                $offset,
                $tbName,
                [$colNo, $colName]);
        }

        if ($deviceNo) {

            return DBHelper::limitWhere($limit,
                $offset,
                $tbName,
                [$colNo, $colName],
                [$colNo => $deviceNo]);
        }
        if ($deviceName) {
            return DBHelper::limitWhere($limit, $offset,
                $tbName,
                [$colNo, $colName],
                ['like', $colName, $deviceName]);

        }
    }
}

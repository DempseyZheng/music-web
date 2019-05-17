<?php

namespace app\controllers;

use app\models\MusicStore;
use app\utils\Constants;
use app\utils\DBHelper;
use app\utils\Debugger;
use app\utils\RedisHelper;
use app\utils\RequestHelper;
use app\utils\Utils;
use app\utils\WebsocketUtil;
use Yii;
use app\models\MusicDevice;
use app\models\MusicDeviceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MusicDeviceController implements the CRUD actions for MusicDevice model.
 */
class MusicDeviceController extends BaseController
{

//    public $enableCsrfValidation = false;


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MusicDevice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MusicDeviceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MusicDevice model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MusicDevice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MusicDevice();
        if ($model->load(Yii::$app->request->post()) && $model->doSave()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MusicDevice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MusicDevice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MusicDevice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MusicDevice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MusicDevice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionQuery()
    {
        return $this->handleQuery(MusicDevice::tableName(), 'deviceNo', 'deviceName');
    }

    public function actionMultiDelete()
    {
        $ids = RequestHelper::getRequest()->post('ids');
        $row = MusicDevice::multiDelete($ids);
        if ($row > 0) {
            $this->redirect('index');
        }

    }

    public static function getRegState($devId)
    {

        $device = MusicDevice::findOne(['mac' => $devId]);

        if ($device) {
            return $device->registerStatus;
        } else {
            return 0;
        }
    }

    public static function getStoreInfo($devId)
    {
        $device = MusicDevice::findOne(['mac' => $devId]);

        $store = MusicStore::findOne(['storeNo' => $device->storeNo]);
        $device->storeName = $store->storeName;
        return $device;
    }

    public function actionRegister()
    {
        $req = RequestHelper::getRequest();
        $devId = $req->post('devId');
        $regCode = $req->post('registerCode');
        Debugger::debug($devId . '==' . $regCode);

        $row = MusicDevice::findOne(['mac' => $regCode]);

        if ($row) {
            $row->mac = $devId;
            $row->registerStatus = 1;
            $row->update();

            return RequestHelper::successMsg();
        }
        return RequestHelper::errMsg('注册失败');
    }

    public static function logout($devId)
    {
        $flag = MusicDevice::findOne(['mac' => $devId]);

        if ($flag) {
            $flag->mac = Utils::getRegCode();
            $flag->registerStatus = 0;
            $flag->update();
            return RequestHelper::successMsg();
        }

        return RequestHelper::errMsg('失败');
    }

    public function actionRestart()
    {
        $ids = RequestHelper::getRequest()->post('ids');
        $arr = DBHelper::newQuery()
            ->select('mac')
            ->from(MusicDevice::tableName())
            ->where(['in', 'id', $ids])
            ->all();
        Debugger::toJson($arr, 'restart');
        WebsocketUtil::handleRestart($arr);

    }

    public function actionSetVolume()
    {
        $ids = RequestHelper::getRequest()->post('ids');
        $volume = RequestHelper::getRequest()->post('volume');

        $arr = DBHelper::newQuery()
            ->select('mac')
            ->from(MusicDevice::tableName())
            ->where(['in', 'id', $ids])
            ->all();

        Debugger::toJson($arr, 'actionSetVolume');
        WebsocketUtil::handleSetVolume($arr,$volume);
    }

    public function actionDevLog()
    {
     return   WebsocketUtil::pushWeb('','这个是推送的测试数据');
    }


}

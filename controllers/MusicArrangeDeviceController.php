<?php

namespace app\controllers;

use app\models\MusicArrange;
use app\models\MusicArrangeItem;
use app\models\MusicDevice;
use app\utils\DBHelper;
use app\utils\Debugger;
use app\utils\RequestHelper;
use app\utils\WebsocketUtil;
use Yii;
use app\models\MusicArrangeDevice;
use app\models\MusicArrangeDeviceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MusicArrangeDeviceController implements the CRUD actions for MusicArrangeDevice model.
 */
class MusicArrangeDeviceController extends Controller
{


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
     * Lists all MusicArrangeDevice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MusicArrangeDeviceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MusicArrangeDevice model.
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
     * Creates a new MusicArrangeDevice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MusicArrangeDevice();

        if ($model->load(Yii::$app->request->post())) {
            $arrange = MusicArrange::findOne(['arrangeNo' => $model->arrangeNo]);
            $device = MusicDevice::findOne(['deviceNo' => $model->deviceNo]);
            if ($arrange == null || $device == null) {
                return $this->render('create', [
                    'model' => $model,
                    'error' => '请输入正确的数据'
                ]);
            }
            $model->arrangeName = $arrange->arrangeName;
            $model->beginDate = $arrange->beginDate;
            $model->endDate = $arrange->endDate;
            $model->beginTime = $arrange->beginTime;
            $model->endTime = $arrange->endTime;
            $model->arrangeLevel = $arrange->arrangeLevel;
            $model->storeNo = $device->storeNo;

            if ($model->doSave())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'error' => null
        ]);
    }

    /**
     * Updates an existing MusicArrangeDevice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $arrange = MusicArrange::findOne(['arrangeNo' => $model->arrangeNo]);
            $device = MusicDevice::findOne(['deviceNo' => $model->deviceNo]);
            if ($arrange == null || $device == null) {
                return $this->render('create', [
                    'model' => $model,
                    'error' => '请输入正确的数据'
                ]);
            }
            $model->arrangeName = $arrange->arrangeName;
            $model->beginDate = $arrange->beginDate;
            $model->endDate = $arrange->endDate;
            $model->beginTime = $arrange->beginTime;
            $model->endTime = $arrange->endTime;
            $model->arrangeLevel = $arrange->arrangeLevel;
            $model->storeNo = $device->storeNo;

            if ($model->doSave())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'error' => null
        ]);
    }

    /**
     * Deletes an existing MusicArrangeDevice model.
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
     * Finds the MusicArrangeDevice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MusicArrangeDevice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MusicArrangeDevice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionArrange()
    {
        $ids = RequestHelper::getRequest()->post('ids');
        $arr = DBHelper::newQuery()
            ->select('music_device.mac,music_arrange_device.arrangeNo')
            ->from(MusicArrangeDevice::tableName())
            ->where(['in', 'music_arrange_device.id', $ids])
            ->where(['pubStatus' => 0])
            ->leftJoin(MusicDevice::tableName(), 'music_arrange_device.deviceNo = music_device.deviceNo')
            ->all();
//        $arrMac=[];
//        foreach ($arr as $item) {
//            $arrMac[]=$item['mac'];
//        }
//     $macs=   array_unique($arrMac);
        if (empty($arr)) {
            Debugger::debug('播期正在发布中...');
            return;
        }
        MusicArrangeDevice::updateAll(['pubStatus' => 1], ['id' => $ids]);
        Debugger::toJson($arr, 'actionArrange');
//        Debugger::toJson($macs, 'mac');

        WebsocketUtil::handlePublish($arr);
    }
    public function actionUpdateStatus()
    {
        $ids = RequestHelper::getRequest()->post('ids');
        $status = RequestHelper::getRequest()->post('status');
        $arr = DBHelper::newQuery()
            ->select('music_device.mac,music_arrange_device.arrangeNo')
            ->from(MusicArrangeDevice::tableName())
            ->where(['in', 'music_arrange_device.id', $ids])
            ->leftJoin(MusicDevice::tableName(), 'music_arrange_device.deviceNo = music_device.deviceNo')
            ->all();

//        if (empty($arr)) {
//            Debugger::debug('播期正在发布中...');
//            return;
//        }
        MusicArrangeDevice::updateAll(['arrangeStatus' => $status], ['id' => $ids]);
        Debugger::toJson($arr, 'actionUpdateStatus');
        WebsocketUtil::handleUpdateStatus($arr,$status);
    }
    public static function pubStatusValue($status)
    {
        if ($status == 0) {
            return '未开始';
        }
        if ($status == 1) {
            return '发布中';
        }
        if ($status == 2) {
            return '发布完成';
        }
        return '发布失败';
    }
    public static function arrangeStatusValue($value)
    {
        if ($value == 0) {
            return '正常';
        }
        if ($value == 1) {
            return '终止';
        }

        return '暂停';
    }
}

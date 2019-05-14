<?php

namespace app\controllers;

use app\models\MusicArrange;
use app\models\MusicArrangeItem;
use app\models\MusicDevice;
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
if ($arrange==null||$device==null){
    return $this->render('create', [
        'model' => $model,
        'error'=>'请输入正确的数据'
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
            'error'=>null
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'error'=>null
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
}

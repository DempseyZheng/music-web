<?php

namespace app\controllers;

use app\utils\DBHelper;
use app\utils\RequestHelper;
use Yii;
use app\models\MusicArrange;
use app\models\MusicArrangeSearch;
use yii\debug\components\search\matchers\Base;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MusicArrangeController implements the CRUD actions for MusicArrange model.
 */
class MusicArrangeController extends BaseController
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
            'access'=>$this->access
        ];
    }

    /**
     * Lists all MusicArrange models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MusicArrangeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MusicArrange model.
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
     * Creates a new MusicArrange model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MusicArrange();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MusicArrange model.
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
     * Deletes an existing MusicArrange model.
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
     * Finds the MusicArrange model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MusicArrange the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MusicArrange::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionQuery()
    {
        $limit = RequestHelper::getRequest()->get('limit');
        $offset = RequestHelper::getRequest()->get('offset');
        $deviceNo = RequestHelper::getRequest()->get('deviceNo');
        $deviceName = RequestHelper::getRequest()->get('deviceName');
        $colNo = 'arrangeNo';
        $colName = 'arrangeName';
        if (empty($deviceNo) && empty($deviceName)) {
            return DBHelper::limitAll($limit,
                $offset,
                MusicArrange::tableName(),
                [$colNo, $colName]);
        }

        if ($deviceNo) {

            return DBHelper::limitWhere($limit,
                $offset,
                MusicArrange::tableName(),
                [$colNo, $colName],
                [$colNo => $deviceNo]);
        }
        if ($deviceName) {
            return DBHelper::limitWhere($limit, $offset,
                MusicArrange::tableName(),
                [$colNo, $colName],
                ['like', $colName, $deviceName]);

        }
    }
}

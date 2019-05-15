<?php

namespace app\controllers;

use app\models\Address;
use app\models\MusicArrangeItem;
use app\utils\DBHelper;
use app\utils\Debugger;
use app\utils\NoBuilder;
use app\utils\RedisHelper;
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
 *     <?=$form->field($model, "[{$i}]musicName")->textInput(['maxlength' => true]) ?>
 *
 * <?= $form->field($model, "[{$i}]musicSize")->textInput() ?>
 *
 * <?= $form->field($model, "[{$i}]musicUrl")->textInput(['maxlength' => true]) ?>
 *
 * <?= $form->field($model, "[{$i}]playTime")->textInput() ?>
 *
 * <?= $form->field($model, "[{$i}]md5")->textInput(['maxlength' => true]) ?>
 *
 * <?= $form->field($model, "[{$i}]createTime")->textInput() ?>
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
            'access' => $this->access
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
        $model = $this->findModel($id);
        $items = $model->musicNos;

        return $this->render('view', [
            'model' => $model,
            'items' => $items,
        ]);
    }

    /**
     * Creates a new MusicArrange model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $arr = $this->multipleCreate(new MusicArrange(), [new MusicArrangeItem()], MusicArrangeItem::className(), __NAMESPACE__ . '\MusicArrangeController::createCall');
        if (!is_array($arr)) {
            return $arr;
        }

        $arr[0]->arrangeNo = NoBuilder::getArrangeNo();
        return $this->render('create', [
            'model' => $arr[0],
            'items' => $arr[1],
            'error' => $arr[2]
        ]);
    }

    public static function updateDelCall($condition)
    {
        MusicArrangeItem::deleteAll($condition);
    }
    public static function updateCall($modelArrange, $modelItem)
    {
        $modelItem->arrangeNo = $modelArrange->arrangeNo;
        return $modelItem;
    }
    public static function createCall($modelArrange, $modelItem)
    {

        $modelItem->arrangeNo = $modelArrange->arrangeNo;
        return $modelItem;
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
        $arr = $this->multipleUpdate($model,
            $model->musicArrangeItems,
            MusicArrangeItem::className(),
            __NAMESPACE__ . '\MusicArrangeController::updateCall',
            __NAMESPACE__ . '\MusicArrangeController::updateDelCall');
        if (!is_array($arr)) {
            return $arr;
        }
        return $this->render('update', [
            'model' => $arr[0],
            'items' => $arr[1],
            'error' => $arr[2]
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
        return $this->handleQuery(MusicArrange::tableName(), 'arrangeNo', 'arrangeName');
    }

}

<?php

namespace app\controllers;

use app\utils\Debugger;
use app\utils\MongoService;
use app\utils\MusicLibraryHandler;
use app\utils\Utils;
use getID3;
use Yii;
use app\models\MusicLibrary;
use app\models\MusicLibrarySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

require_once 'getid3/getid3.php';

/**
 * MusicLibraryController implements the CRUD actions for MusicLibrary model.
 */
class MusicLibraryController extends BaseController
{
    public static function createMusic($path, $filename)
    {
        Debugger::log($path, '路径');
        $file = fopen($path, 'rb');
        $bucket = MongoService::getDB()->selectGridFSBucket();
        $fileId = $bucket->uploadFromStream($filename, $file);
        Debugger::log($fileId, '文件id');

        $musicLib = new MusicLibrary();
        $musicLib->musicNo = Utils::micTime().'';
        $musicLib->musicName = $filename;
        $musicLib->musicSize = filesize($path);
        $musicLib->musicUrl = 'download?id=' . $fileId;
        $getID3 = new getID3();    //实例化类
        $ThisFileInfo = $getID3->analyze($path);   //分析文件

        $musicLib->playTime = round($ThisFileInfo['playtime_seconds']);
        $musicLib->md5 = md5_file($path);
        $musicLib->doSave();

    }

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
     * Lists all MusicLibrary models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MusicLibrarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MusicLibrary model.
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
     * Creates a new MusicLibrary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        new MusicLibraryHandler();
    }


//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//
//        return $this->render('update', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Deletes an existing MusicLibrary model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
//  $url=      $model->musicUrl;
        $fileId = explode('=',$model->musicUrl)[1];
        Debugger::log($fileId, '删除音乐');
        MongoService::deleteFile($fileId);
        return $this->redirect(['index']);
    }

    /**
     * Finds the MusicLibrary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MusicLibrary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MusicLibrary::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionQuery()
    {
        return $this->handleQuery(MusicLibrary::tableName(), 'musicNo', 'musicName');
    }
}

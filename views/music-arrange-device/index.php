<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MusicArrangeDeviceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Music Arrange Devices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="music-arrange-device-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Music Arrange Device'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'deviceNo',
            'arrangeNo',
            'arrangeName',
            'storeNo',
            'progress',
            'pubStatus',
            'arrangeStatus',
            'beginDate',
            'endDate',
            //'beginTime',
            //'endTime',
            'arrangeLevel',
            //'createTime',
            //'updateTime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

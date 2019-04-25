<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MusicLibrarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Music Libraries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="music-library-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Music Library', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'musicNo',
            'musicName',
            'musicSize',
            'musicUrl',
            //'playTime:datetime',
            //'md5',
            //'createTime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

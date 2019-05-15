<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MusicArrangeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '播期列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="music-arrange-index">



    <p>
        <?= Html::a('创建播期', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'arrangeNo',
            'arrangeName',
            'customerName',
            'beginDate',
            'endDate',
            //'beginTime',
            //'endTime',
            //'arrangeLevel',
            //'createTime',
            //'updateTime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

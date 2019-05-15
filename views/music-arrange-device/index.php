<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MusicArrangeDeviceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Music Arrange Devices');
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
    function arrange() {

    }

    function updateStatus() {

    }
</script>
<div class="music-arrange-device-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Music Arrange Device'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('发布播期', "javascript:void(0);", ['class' => 'btn btn-success', 'onclick' => 'arrange()']) ?>
        <?= Html::a('修改状态', "javascript:void(0);", ['class' => 'btn btn-success', 'onclick' => 'updateStatus()']) ?>
    </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'id' => 'grid'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],

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
            [
                'attribute' => 'arrangeLevel',
                'value' => function ($model) {
                    if ($model->arrangeLevel == 0) {
                        return '普通';
                    }
                    return '高';
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

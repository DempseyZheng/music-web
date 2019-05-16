<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MusicArrangeDeviceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Music Arrange Devices');
$this->params['breadcrumbs'][] = $this->title;
\app\assets\JqueryTipAsset::register($this);
?>
<script>
    function arrange() {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        if (keys.length === 0) {
            xcsoft.error('请至少选择一个设备',2000);
            return
        }
        $.post('arrange', {ids: keys}, function (data) {
            console.log(data);
        })
    }

    function updateStatus(status) {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        if (keys.length === 0) {
            xcsoft.error('请至少选择一个设备',2000);
            return
        }
        $.post('update-status', {ids: keys,status:status}, function (data) {
            console.log(data);
            window.location.reload();
        })
    }
</script>
<div class="music-arrange-device-index xctips-container">

    <h1><?= Html::encode($this->title) ?></h1>

    <div>
        <?= Html::a(Yii::t('app', 'Create Music Arrange Device'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('发布播期', "javascript:void(0);", ['class' => 'btn btn-success', 'onclick' => 'arrange()']) ?>
    <div class="btn-group">
        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            修改状态 <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="javascript:void(0);" onclick="updateStatus(0)">恢复</a></li>
            <li><a href="#" onclick="updateStatus(1)">终止</a></li>
            <li><a href="#" onclick="updateStatus(2)">暂停</a></li>
        </ul>
    </div>
    </div>
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
            [
                'attribute' => 'pubStatus',
                'value' => function ($model) {
                   return \app\controllers\MusicArrangeDeviceController::pubStatusValue($model->pubStatus);
                }
            ],
            [
                'attribute' => 'arrangeStatus',
                'value' => function ($model) {
                    return \app\controllers\MusicArrangeDeviceController::arrangeStatusValue($model->arrangeStatus);
                }
            ],
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
            ['class' => 'yii\grid\ActionColumn','template' => '{view} {delete}'],
        ],
    ]); ?>


</div>

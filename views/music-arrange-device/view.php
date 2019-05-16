<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MusicArrangeDevice */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Music Arrange Devices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="music-arrange-device-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'storeNo',
            'deviceNo',
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
            'arrangeNo',
            'arrangeName',
            'beginDate',
            'endDate',
            'beginTime',
            'endTime',
            [
                'attribute' => 'arrangeLevel',
                'value' => function ($model) {
                    if ($model->arrangeLevel == 0) {
                        return '普通';
                    }
                    return '高';
                }
            ],
            'createTime',
            'updateTime',
        ],
    ]) ?>

</div>

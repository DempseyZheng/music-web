<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MusicDevice */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Music Devices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="music-device-view">

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
            'deviceNo',
            'deviceName',
            'mac',
            'storeNo',
//            'onlineStatus',
            [
                'attribute' => 'onlineStatus',
                'value' => function ($model) {
                    if ($model->onlineStatus == 0) {
                        return '离线';
                    }
                    return '在线';
                }
            ],
//            'registerStatus',
            [
                'attribute' => 'registerStatus',
                'value' => function ($model) {
                    if ($model->onlineStatus == 0) {
                        return '未注册';
                    }
                    return '已注册';
                }
            ],
            'storageCard',
            'appVersion',
            'deviceSound',
            'lastMsgTime',
            'createTime',
            'updateTime',
        ],
    ]) ?>

</div>

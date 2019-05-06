<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MusicArrange */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Music Arranges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="music-arrange-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'arrangeNo',
            'arrangeName',
            'customerName',
            'beginDate',
            'endDate',
            'beginTime',
            'endTime',
            'arrangeLevel',
            'createTime',
            'updateTime',
        ],
    ]) ?>

    <hr style="height:1px;border:none;border-top:1px dashed #000;" />
    <h4>音乐列表</h4>
    <?php foreach ($items as $i => $modelAddress): ?>
        <?= DetailView::widget([
            'model' => $modelAddress,
            'attributes' => [
                'id',
                'musicNo',
            ],
        ]) ?>
    <?php endforeach; ?>

</div>

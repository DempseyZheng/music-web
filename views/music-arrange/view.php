<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MusicArrange */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '播期列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="music-arrange-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '您确定要删除此项吗？',
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
//            'arrangeLevel',
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

    <hr style="height:1px;border:none;border-top:1px dashed #000;"/>
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

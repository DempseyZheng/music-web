<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MusicLibrary */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Music Libraries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="music-library-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
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
            'musicNo',
            'musicName',
//            'musicSize',
            [
                'attribute' => 'musicSize',
                'value' => function ($model) {
                    return \app\utils\Utils::formatSize($model->musicSize);
                }
            ],
            'musicUrl',
//            'playTime',
            [
                'attribute' => 'playTime',
                'value' => function ($model) {
                    return \app\utils\Utils::secToTime($model->playTime);
                }
            ],
            'md5',
            'createTime'

        ],
    ]) ?>


</div>

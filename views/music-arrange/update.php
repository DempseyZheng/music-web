<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MusicArrange */

$this->title = '更新播期: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '播期列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="music-arrange-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'items' => $items,
        'error' => $error,
    ]) ?>

</div>

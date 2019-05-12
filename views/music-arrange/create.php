<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MusicArrange */

$this->title = '创建播期';
$this->params['breadcrumbs'][] = ['label' => '播期列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="music-arrange-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'items' => $items,
        'error' => $error,
    ]) ?>

</div>

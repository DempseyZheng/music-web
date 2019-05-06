<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MusicArrange */

$this->title = 'Create Music Arrange';
$this->params['breadcrumbs'][] = ['label' => 'Music Arranges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="music-arrange-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'items' => $items,
    ]) ?>

</div>

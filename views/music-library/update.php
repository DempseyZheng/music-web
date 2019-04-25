<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MusicLibrary */

$this->title = 'Update Music Library: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Music Libraries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="music-library-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MusicDevice */

$this->title = Yii::t('app', 'Create Music Device');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Music Devices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="music-device-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,

    ]) ?>

</div>

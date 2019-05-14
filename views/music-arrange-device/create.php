<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MusicArrangeDevice */

$this->title = Yii::t('app', 'Create Music Arrange Device');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Music Arrange Devices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="music-arrange-device-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'error'=>$error
    ]) ?>

</div>

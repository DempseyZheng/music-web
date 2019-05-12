<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MusicDeviceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="music-device-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'deviceNo') ?>

    <?= $form->field($model, 'deviceName') ?>

    <?= $form->field($model, 'mac') ?>

    <?= $form->field($model, 'storeNo') ?>

    <?php // echo $form->field($model, 'onlineStatus') ?>

    <?php // echo $form->field($model, 'registerStatus') ?>

    <?php // echo $form->field($model, 'storageCard') ?>

    <?php // echo $form->field($model, 'appVersion') ?>

    <?php // echo $form->field($model, 'deviceSound') ?>

    <?php // echo $form->field($model, 'lastMsgTime') ?>

    <?php // echo $form->field($model, 'createTime') ?>

    <?php // echo $form->field($model, 'updateTime') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

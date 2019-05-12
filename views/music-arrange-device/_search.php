<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MusicArrangeDeviceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="music-arrange-device-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'storeNo') ?>

    <?= $form->field($model, 'deviceNo') ?>

    <?= $form->field($model, 'progress') ?>

    <?= $form->field($model, 'pubStatus') ?>

    <?php // echo $form->field($model, 'arrangeStatus') ?>

    <?php // echo $form->field($model, 'arrangeNo') ?>

    <?php // echo $form->field($model, 'arrangeName') ?>

    <?php // echo $form->field($model, 'beginDate') ?>

    <?php // echo $form->field($model, 'endDate') ?>

    <?php // echo $form->field($model, 'beginTime') ?>

    <?php // echo $form->field($model, 'endTime') ?>

    <?php // echo $form->field($model, 'arrangeLevel') ?>

    <?php // echo $form->field($model, 'createTime') ?>

    <?php // echo $form->field($model, 'updateTime') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

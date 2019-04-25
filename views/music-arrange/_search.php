<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MusicArrangeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="music-arrange-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'arrangeNo') ?>

    <?= $form->field($model, 'arrangeName') ?>

    <?= $form->field($model, 'customerName') ?>

    <?= $form->field($model, 'beginDate') ?>

    <?php // echo $form->field($model, 'endDate') ?>

    <?php // echo $form->field($model, 'beginTime') ?>

    <?php // echo $form->field($model, 'endTime') ?>

    <?php // echo $form->field($model, 'arrangeLevel') ?>

    <?php // echo $form->field($model, 'createTime') ?>

    <?php // echo $form->field($model, 'updateTime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

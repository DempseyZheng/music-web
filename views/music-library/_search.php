<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MusicLibrarySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="music-library-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'musicNo') ?>

    <?= $form->field($model, 'musicName') ?>

    <?= $form->field($model, 'musicSize') ?>

    <?= $form->field($model, 'musicUrl') ?>

    <?php // echo $form->field($model, 'playTime') ?>

    <?php // echo $form->field($model, 'md5') ?>

    <?php // echo $form->field($model, 'createTime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
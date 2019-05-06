<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MusicLibrary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="music-library-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'musicNo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'musicName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'musicSize')->textInput() ?>

    <?= $form->field($model, 'musicUrl')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'playTime')->textInput() ?>

    <?= $form->field($model, 'md5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'createTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

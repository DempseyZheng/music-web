<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MusicStore */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="music-store-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'storeNo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'storeName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customerName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

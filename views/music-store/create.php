<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MusicStore */

$this->title = Yii::t('app', 'Create Music Store');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Music Stores'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="music-store-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

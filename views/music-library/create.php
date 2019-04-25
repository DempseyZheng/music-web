<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MusicLibrary */

$this->title = 'Create Music Library';
$this->params['breadcrumbs'][] = ['label' => 'Music Libraries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="music-library-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

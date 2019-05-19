<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */


?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="<?= Yii::$app->language ?>" class="has-scroll">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<?php

if (Yii::$app->controller->action->id === 'login') {
    /**
     * Do not use this code in your template. Remove it.
     * Instead, use the code  $this->layout = '//main-login'; in your controller.
     */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {
app\assets\AppAsset::register($this);


//    \app\assets\AdminLteAsset::register($this);
\app\assets\BsTabsAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>

<div style="height: 100%">

    <?=
    Breadcrumbs::widget(
        [
        'homeLink'=> false,
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]
    ) ?>
    <?= $content ?>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


<?php } ?>

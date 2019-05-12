<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MusicLibrarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Music Libraries');
$this->params['breadcrumbs'][] = $this->title;
?>

<script>
    $(function () {

        $('#fileupload').fileupload({
            url: 'create'
        });
    });
    function uploadMusic() {
        $('#jqUploadModel').modal('show');
    }
</script>

<?php echo $this->render('@app/views/cmpt/jqupload'); ?>
<div class="music-library-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Music Library'), null, ['class' => 'btn btn-success','onclick'=>'uploadMusic()']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'musicNo',
            'musicName',
            'musicSize',
            'musicUrl',
            //'playTime:datetime',
            //'md5',
            //'createTime',

            ['class' => 'yii\grid\ActionColumn','template' => '{view} {delete}'],
        ],
    ]); ?>


</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MusicDeviceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Music Devices');
$this->params['breadcrumbs'][] = $this->title;
\app\assets\JquerySliderAsset::register($this);
\app\assets\JqueryTipAsset::register($this);
\app\assets\WebMsgAsset::register($this);
?>

<script>

    $(function () {
        var handle = $("#custom-handle");
        $("#slider").slider({
            orientation: "horizontal",
            range: "min",
            animate: true,
            create: function () {
                handle.text($(this).slider("value"));
            },
            slide: function (event, ui) {
                handle.text(ui.value);
            }
        });

var url='http://'+document.domain+':2120';
// console.log(url);
        // 连接服务端
        var socket = io(url);
        // 连接后登录
        socket.on('connect', function(){
            console.log('connect');
            socket.emit('login', '1564156461');
        });
        // 后端推送来消息时
        socket.on('new_msg', function(msg){
            console.log('new_msg'+msg);
            // $('#content').html('收到消息：'+msg);
            // $('.notification.sticky').notify();
        });
        // 后端推送来在线数据时
        socket.on('update_online_count', function(online_stat){
            // $('#online_box').html(online_stat);
            console.log('update_online_count'+online_stat);
        });

    });

    function onSlideConfirm() {
        $('#slideModel').modal('hide');
        var keys = $("#grid").yiiGridView("getSelectedRows");
        if (keys.length === 0) {
            return
        }
        $.post('set-volume', {ids: keys,volume:$("#slider").slider("value")}, function (data) {
            xcsoft.info(data,2000);
        })
    }

    function multiDelete() {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        console.log(keys);
        if (keys.length === 0) {
            return
        }
        console.log('删除');
        $.post('multi-delete', {ids: keys}, function (data) {
            console.log(data);
        })
    }

    function setVolume() {
       if ( $("#grid").yiiGridView("getSelectedRows").length===0){
           xcsoft.error('请至少选择一个设备',2000);
           return
       }
        $('#slideModel').modal('show')
    }

    function restart() {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        if (keys.length === 0) {
            xcsoft.error('请至少选择一个设备',2000);
            return
        }
        $.post('restart', {ids: keys}, function (data) {
            console.log(data);
            xcsoft.info(data,2000);
        })
    }
    function devLog() {
        $.post('dev-log', {}, function (data) {
            console.log(data);
        })
    }
</script>

<?php echo $this->render('@app/views/cmpt/slidemodel'); ?>
<div class="music-device-index xctips-container">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Music Device'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), "javascript:void(0);", ['class' => 'btn btn-success', 'onclick' => 'multiDelete()']) ?>
        <?= Html::a('设置音量', "javascript:void(0);", ['class' => 'btn btn-success', 'onclick' => 'setVolume()']) ?>
        <?= Html::a('重启设备', "javascript:void(0);", ['class' => 'btn btn-success', 'onclick' => 'restart()']) ?>
        <?= Html::a('获取日志', "javascript:void(0);", ['class' => 'btn btn-success', 'onclick' => 'devLog()']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            if ($model->onlineStatus === 1)
                return ['class' => 'success'];
        },

        'options' => [
            'id' => 'grid'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],
//            'id',
            'deviceNo',
            'deviceName',
            'mac',
            'storeNo',
//            'onlineStatus',
            [
                'attribute' => 'onlineStatus',
                'value' => function ($model, $key, $index, $column) {
                    return $model->onlineStatus == 1 ? '在线' : '离线';
                },
                //在条件（过滤条件）中使用下拉框来搜索
                'filter' => ['1' => '在线', '0' => '离线'],
            ],

//            'registerStatus',
            [
                'attribute' => 'registerStatus',
                'value' => function ($model, $key, $index, $column) {
                    return $model->registerStatus == 1 ? '已注册' : '未注册';
                },
                //在条件（过滤条件）中使用下拉框来搜索
                'filter' => ['1' => '已注册', '0' => '未注册'],
            ],
//            'storageCard',
            'appVersion',
            'deviceSound',
            'lastMsgTime',
            //'createTime',
            //'updateTime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

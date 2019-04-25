<?php

use app\widgets\DateTimePicker;

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MusicArrange */

/* @var $form yii\widgets\ActiveForm */

use app\assets\BootstrapTableAsset;

BootstrapTableAsset::register($this);
?>
<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/icon.css">
<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/color.css">

<script>
var isDbClick=false;
    $(function () {

        initTable("",[]);


    });

    function initTable(initParams) {
        $('#table').bootstrapTable({
            url: initParams.url, //请求地址
            method: 'GET', //请求
            striped: true,
            cache: false,
            pagination: true,
            sortable: true,
            showHeader: true,
            showRefresh: false,
            clickToSelect: true,
            search: false,
            sidePagination: "server", //客户端client   服务端server
            pageNumber: 1,
            pageList: [5, 15],
            queryParams: function (params) {
                return {
                    offset: params.offset,  //页码
                    limit: params.limit,   //页面大小
                    deviceNo: $('#device_no_input').val(),
                    deviceName: $('#device_name_input').val(),
                };
            },

            columns: initParams.columns,
            onDblClickRow: function (row) {
                isDbClick = true;
                var msg='';
                switch ($('#model_type').text()) {
                    case "1":
                        msg=row.deviceNo;
                        // $('#model_value').text(row.deviceNo);
                        break;
                    case "2":
                        msg=row.arrangeNo;
                        // $('#model_value').text(row.arrangeNo);
                        break;
                }
                        $('#'+$('#model_id').text()).val(msg);
                $('#myModal').modal('hide');
            }
        });
    }

</script>
<?php echo $this->render('@app/views/cmpt/querymodal'); ?>
<div class="music-arrange-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'arrangeNo')->widget(\app\widgets\SearchInput::className(), [
        'searchType' => 1

    ])
    ?>

    <?= $form->field($model, 'arrangeName')->widget(\app\widgets\SearchInput::className(), [
        'searchType' => 2
    ]) ?>

    <?= $form->field($model, 'customerName')->textInput(['maxlength' => true, 'placeholder' => '请输入客户名称'])->label('客户名称') ?>
    <?= $form->field($model, 'beginDate')->widget(DateTimePicker::classname(), [
        'language' => 'zh-CN',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'todayBtn' => true,
            'todayHighlight' => true,
            'minView' => "month",


        ]]); ?>


    <?= $form->field($model, 'endDate')->textInput() ?>

    <?= $form->field($model, 'beginTime')->widget(DateTimePicker::classname(), [
        'language' => 'zh-CN',
        'clientOptions' => [
            'forceParse' => false,
            'startView' => 1,
            'autoclose' => true,
            'format' => 'hh:ii:ss',
            'todayBtn' => true

        ]]); ?>

    <?= $form->field($model, 'endTime')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'arrangeLevel')->textInput() ?>

    <?= $form->field($model, 'createTime')->textInput() ?>

    <?= $form->field($model, 'updateTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

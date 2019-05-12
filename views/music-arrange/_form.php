<?php

use app\widgets\DateTimePicker;

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MusicArrange */

/* @var $form yii\widgets\ActiveForm */

use app\assets\BootstrapTableAsset;
use wbraganca\dynamicform\DynamicFormWidget;

BootstrapTableAsset::register($this);
//\app\assets\BootstrapEditableAsset::register($this);
?>
<!--<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/default/easyui.css">-->
<!--<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/icon.css">-->
<!--<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/color.css">-->

<script>
    var isDbClick = false;
    $(function () {
        initTable({id: '#table'}, onDbClick);

        // $(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
        //     console.log(e);
        //     console.log(item);
        // });
    });

    function onDbClick(row) {
        isDbClick = true;
        var msg = row.musicNo;
        // console.log(msg);
        $('#' + $('#model_id').text()).val(msg);
        $('#myModal').modal('hide');
    }

    function initTable(initParams, onDbClick) {
        $(initParams.id).bootstrapTable({
            url: initParams.url, //请求地址
            method: 'GET', //请求
            editable: initParams.editable,
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
                    queryNo: $('#device_no_input').val(),
                    queryName: $('#device_name_input').val(),
                };
            },

            columns: initParams.columns,
            onDblClickRow: onDbClick
        });
    }

    function onSearch(obj) {

        var input = $(obj).parent().find('.form-control');

        $('#model_id').text(input.attr('id'));
        $('#device_name_input').val('');
        $('#device_no_input').val('');

        $('#table').bootstrapTable('refreshOptions', {
            url: '/music-library/query',
            columns: [
                {
                    field: 'musicNo',
                    title: '音乐编号',
                    width: '10%',
                },
                {
                    field: 'musicName',
                    title: '音乐名称',
                }]
        });

        $('#myModal').modal('show');


    }
</script>
<?php echo $this->render('@app/views/cmpt/querymodal'); ?>
<div class="music-arrange-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'arrangeNo')->textInput(['value' => $model->arrangeNo, 'readonly' => 'readonly'])->label('播期编号') ?>
    <?= $form->field($model, 'arrangeName')->textInput(['maxlength' => true, 'placeholder' => '请输入播期名称'])->label('播期名称') ?>
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

    <?= $form->field($model, 'endDate')->widget(DateTimePicker::classname(), [
        'language' => 'zh-CN',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'todayBtn' => true,
            'todayHighlight' => true,
            'minView' => "month",
        ]]); ?>

    <?= $form->field($model, 'beginTime')->widget(DateTimePicker::classname(), [
        'language' => 'zh-CN',
        'clientOptions' => [
            'forceParse' => false,
            'startView' => 1,
            'autoclose' => true,
            'format' => 'hh:ii:ss',
            'todayBtn' => true
        ]]); ?>

    <?= $form->field($model, 'endTime')->widget(DateTimePicker::classname(), [
        'language' => 'zh-CN',
        'clientOptions' => [
            'forceParse' => false,
            'startView' => 1,
            'autoclose' => true,
            'format' => 'hh:ii:ss',
            'todayBtn' => true
        ]]); ?>

    <?= $form->field($model, 'arrangeLevel')->textInput() ?>

    <div class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> 音乐列表</h4>
<!--            <p style="color: red"></p>-->
        <?php if ($error){
          echo  Html::tag('p',$error,['style'=>'color: red']);
        } ?>
        </div>
        <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $items[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'musicNo',
//                    'musicName',
//                    'musicSize',
//                    'musicUrl',
//                    'playTime',
//                    'md5',
//                    'createTime'
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
                <?php foreach ($items as $i => $modelMusic): ?>
                    <div class="item panel panel-default"><!-- widgetBody -->
                        <div class="panel-heading">
                            <h3 class="panel-title pull-left">音乐</h3>
                            <div class="pull-right">
                                <button type="button" class="add-item btn btn-success btn-xs"><i
                                            class="glyphicon glyphicon-plus"></i></button>
                                <button type="button" class="remove-item btn btn-danger btn-xs"><i
                                            class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php
                            // necessary for update action.
                            if (!$modelMusic->isNewRecord) {
                                echo Html::activeHiddenInput($modelMusic, "[{$i}]id");
                            }
                            ?>


                            <?= $form->field($modelMusic, "[{$i}]musicNo")->widget(\app\widgets\DynamicSearchInput::className()) ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MusicArrangeDevice */
/* @var $form yii\widgets\ActiveForm */
app\assets\BootstrapTableAsset::register($this);
app\assets\QueryTableAsset::register($this);
?>
<script>
    function refreshQueryTable(type) {
        console.log(type);
        var url= '/music-device/query';
        var columns=[
            {
                field: 'deviceNo',
                title: '设备编号',
                width: '10%',
            },
            {
                field: 'deviceName',
                title: '设备名称',
            }];
      if (type===2){
           url= '/music-arrange/query';
           columns=[
              {
                  field: 'arrangeNo',
                  title: '播期编号',
                  width: '10%',
              },
              {
                  field: 'arrangeName',
                  title: '播期名称',
              }];
      }
        $('#table').bootstrapTable('refreshOptions', {
            url: url,
            columns: columns
        });
    }
    function getDbClickMsg(row,type) {
        if (type === 2) {

            return row.arrangeNo;
        }
        return row.deviceNo;
    }

</script>
<?php echo $this->render('@app/views/cmpt/querymodal'); ?>
<div class="music-arrange-device-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, "deviceNo")->widget(\app\widgets\DynamicSearchInput::className(),['searchType'=>1]) ?>
    <?= $form->field($model, "arrangeNo")->widget(\app\widgets\DynamicSearchInput::className(),['searchType'=>2]) ?>





    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

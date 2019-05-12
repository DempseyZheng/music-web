<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MusicDevice */
/* @var $form yii\widgets\ActiveForm */
app\assets\BootstrapTableAsset::register($this);
app\assets\QueryTableAsset::register($this);
?>
<script>
    function refreshQueryTable() {
        $('#table').bootstrapTable('refreshOptions', {
            url: '/music-store/query',
            columns: [
                {
                    field: 'storeNo',
                    title: '门店编号',
                    width: '10%',
                },
                {
                    field: 'storeName',
                    title: '门店名称',
                }]
        });
    }
    function getDbClickMsg(row) {
        return row.storeNo;
    }

</script>
<?php echo $this->render('@app/views/cmpt/querymodal'); ?>
<div class="music-device-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'deviceNo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deviceName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mac')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, "storeNo")->widget(\app\widgets\DynamicSearchInput::className()) ?>



    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

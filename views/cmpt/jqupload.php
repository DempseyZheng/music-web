<?php

use app\assets\JqueryUploadAsset;

JqueryUploadAsset::register($this);
?>
<div class="modal fade" id="jqUploadModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    上传文件
                </h4>
            </div>
            <div class="modal-body">
 <span class="btn btn-success fileinput-button" id="upload_btn">
        <i class="glyphicon glyphicon-plus"></i>
        <span>选择文件...</span>

        <input id="fileupload" type="file" name="files[]" multiple>
    </span>
                <button id="btn_submit" class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>全部上传</span>
                </button>
                <button id="btn_resubmit" class="btn btn-primary start">
                    <i class="glyphicon glyphicon-repeat"></i>
                    <span>全部重传</span>
                </button>
                <br>
                <br>


                <div id="files" class="files"></div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
